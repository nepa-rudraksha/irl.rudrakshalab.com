<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\IrlReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class CreateIrlReport extends Component
{
    use WithFileUploads;
    public $report;
    public $irlReport;
    public $repo;
    public $qr;
    public $irlReportId;
    public $userId;
    public $action;
    public $button;

    protected $listeners = ['deleteDownload' => 'deleteDownload'];

    protected function getRules()
    {
        $rules = [

            'irlReport.email' => 'required_without:irlReport.phone|email',
            'irlReport.name' => 'required',
            'irlReport.created_at' => 'required|date',
            'irlReport.reference_no' => 'required|unique:irl_reports,reference_no',
            'irlReport.status' => 'required',
            'report' => 'mimetypes:application/pdf|max:100000|nullable',
            'irlReport.phone' => 'required_without:irlReport.email',
        ];

        if (isset($this->irlReportId)) {
            $rules['irlReport.reference_no'] = 'required|unique:irl_reports,reference_no, ' .  $this->irlReportId;
        }

        return $rules;
    }


    public function updatedReport()
    {
        $this->validate([
            'report' => 'mimetypes:application/pdf|max:100000|nullable', // 1MB Max
        ]);
            return redirect()->back();

    }

    public function updatedIrlReportReferenceNo()
    {
        $this->qr = "";
        $this->validate([
            'irlReport.reference_no' => 'unique:irl_reports,reference_no', // 1MB Max
        ]);



        $reference_no = $this->irlReport['reference_no'];

        $email_phone = isset($this->irlReport['email']) ? $this->irlReport['email'] : $this->irlReport['phone'];
        $img = base64_encode(QrCode::size(200)->format('png')->generate(IrlReport::generateURL($reference_no, $email_phone)));
        $this->qr = "<img src='data:image/png;base64, {$img}'> ";
    }

    public function createIrlReport()
    {
        $this->resetErrorBag();
        $this->validate();



        $this->repo = new IrlReport();
        $this->repo->name = $this->irlReport['name'];

        $this->repo->phone = $this->irlReport['phone'];
        $this->repo->email = $this->irlReport['email'];
        $this->repo->reference_no = $this->irlReport['reference_no'];
        $this->repo->created_at = $this->irlReport['created_at'];

        if ($this->report) {
            $this->repo->status = $this->irlReport['status'];
        } else {
            $this->repo->status = IrlReport::DRAFT;
        }
        $this->repo->created_by = $this->user->name;
        $this->repo->user_id = $this->user->id;

        if ($this->report) {
            $name = (string) Str::uuid() . $this->irlReport['reference_no'] . "." . $this->report->extension();
            $this->repo->pdf_url = $name;
            $this->report->storeAs('/report', $name, 'public');
        }

        $this->emit('saved');
        $this->repo->save();
        $this->reset('irlReport');
        $this->reset('repo');
        $this->irlReport['reference_no'] = IrlReport::getNextReferenceNo();
    }

    public function update()
    {
        $this->resetErrorBag();
        $this->validate();

        $this->repo->name   = $this->irlReport['name'];
        $this->repo->phone  = $this->irlReport['phone'];
        $this->repo->email  = $this->irlReport['email'];
        $this->repo->reference_no = $this->irlReport['reference_no'];
        $this->repo->created_at = $this->irlReport['created_at'];
        $this->repo->user_id =   $this->user->id;


        if ($this->report ||  $this->repo->pdf_url) {
            $this->repo->status = $this->irlReport['status'];
        } else {
            $this->repo->status = IrlReport::DRAFT;
        }

        if ($this->report) {
            //remove old Image
            Storage::disk('public')->delete('report/' .  $this->repo->pdf_url);
            $name = (string) Str::uuid() . $this->irlReport['reference_no'] . "." . $this->report->extension();
            $this->repo->pdf_url = $name;
            $this->report->storeAs('/report', $name, 'public');
            // $filename = $this->report->store('report', 'public');
        }

        $this->repo->save();
        $this->emit('saved');
        $this->emit('saved');
        return redirect()->back();

    }

    public function deleteDownload($id)
    {
        Storage::disk('public')->delete('report/' .  $this->repo->pdf_url);
        $this->repo->pdf_url = null;
        $this->irlReport['pdf_url'] = null;
        $this->repo->save();
    }

    public function mount()
    {
        $this->user = auth()->user();

        if (!$this->irlReport && $this->irlReportId) {
            $this->repo = IrlReport::find($this->irlReportId);
            $this->irlReport = $this->repo->toArray();
            $reference_no = $this->irlReport['reference_no'];
            $email_phone = $this->irlReport['email'];
            $this->action = "update";
        } else {
            $reference_no = $this->irlReport['reference_no'] = IrlReport::getNextReferenceNo();
            $email_phone = '';
            $this->irlReport['email'] = $email_phone;
            $this->irlReport['status'] = IrlReport::DRAFT;
        }
        $img = base64_encode(QrCode::size(200)->format('png')->generate(IrlReport::generateURL($reference_no, $email_phone)));

        $this->qr = "<img src='data:image/png;base64, {$img}'> ";
        $this->button = create_button($this->action, "Irl");
    }


    public function render()
    {
        return view('livewire.create-irl-report');
    }
}
