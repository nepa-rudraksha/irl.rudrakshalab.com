

<!DOCTYPE html>
<html>
  <head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    
    <link rel="stylesheet" href="style.css" />
    <script src="html2pdf.js"></script>
      
    <body>
    <!-- /* Pop up / alert Box / Model box  */ -->
      <div id="alert-body">
        <div id = "alert">
          <p id="alert-msg"> Welcome to the tutorialsPoint! </p>
          <button class="closePopup" id="PopupBtn1"> Add value to origin</button>
          <button class="closePopup" id="PopupBtn2"> Replace value to origin</button>
        </div>
      </div>

        
      <!-- for multi select with search feature dropdown box -->
      <div id="multiSelectCdn">
        <link
        rel="stylesheet"
        type="text/css"
        href="bootstrap.css"
        />
        <link
        rel="stylesheet"
        type="text/css"
        href="bootstrap-select.min.css"
        />
        <script
        type="text/javascript"
        src="bootstrap.bundle.js"
        ></script>
        <script
        type="text/javascript"
        src="bootstrap-select.min.js"
        ></script>
      </div>
      <link rel="stylesheet" href="style.css" />
    <div id="mad">    
      <page id="page1" class="page" size="A4" layout="landscape">

      <!-- begning of the front page  -->      
      <div class="front-page">
       <!-- validation section with qr code  -->
        <center class="validation section">
          <div class="validation-header">
            <h3>Validate Your Report</h3>
            <input
              type="file"
              accept="image/*"
              name="image"
              id="qr"
              onchange="loadFile(event,'qr-code')"
              style="display: none"
            />

            <label for="qr" style="cursor: pointer; position: relative">
              <span class="upload-msg" id="upload-msg" style="z-index: 1; width: max-content"
                >Upload Qr Code Here</span
              >
              <img id="qr-code" height="140" style="display: none" />
              <span class="image-alert" id="image-alert" style="display: none"
                >Click Here to change the Image</span
              >
            </label>
          </div>
          <span>
            IRL reports can be verified online to ensure authenticity and
            reliability of the reports. Customers can also download additional
            digital copies for their records. Please scan the above QR code with
            your mobile phone camera
          </span>
          <div class="validation-footer">
            <img src="img/signature.png" alt="signature" width="75.6" />
            <span class="signature-name">Vilaxan Sharma</span>
            <span class="signature-specialist">Rudraksha Specialist</span>
          </div>
        </center>

        <!-- Terms and conditions section  -->
        <center class="section">
          <div class="termsNconditions">
            <h4>Terms and Conditions</h4>
            <ul>
              <li>
                IRL is not affiliated to any individual person or organization
                and it is strongly prohibited to use IRL's name or logo without
                prior consent.
              </li>
              <li>
                IRL uses standardized equipment and experts to guarantee Test
                Reults. However, human error might result in failure to identify
                minor cracks or damages to Rudraksha Bead.
              </li>
              <li>
                The validity of the certificate shall be lost if the certificate
                is damaged or tampered in any way visible to the human eye.
              </li>
              <li>
                IRL does not gather any pricing information of the Rudraksha and
                is solely dedicated to identifying the authenticity and origin
                of Rudraksha Beads.
              </li>
              <li>
                IRL preserves the right to change and modify its terms and
                conditions without providing any advance notice to its customers
                or stakeholders.
              </li>
            </ul>
          </div>
          <div>
            <hr />
            <div class="footer-location">
              <span> International Rudraksha Laboratory Pvt. Ltd. </span>
              <span>Pingalsthan Gaushala - 9, Kathmandu,Nepal </span
                ><span>Ph: +977 1 5241176 </span>
              </div>
            </div>
        </center>

        
        <!-- Front page or the cover page of IRL report -->
        <div class="section cover-page">
          <!-- <span class="horizontal-text">
            INternational Rudraksha laboratory
          </span> -->
          <img src="img/background.jpg" style="box-sizing: initial;height: 12.6cm;margin-top: -1px;"/>
          
          <!-- IRL logo portion -->
          <center style="background: url(img/Irl-logo-bg.jpg); background-position: center; background-size: contain; }">
          <img src="img/Irl-logo-bg.jpg" alt="logo " style="width:100%;">  
         </center>
        </div>
      </div>
    </page>

    <page contenteditable="true" id="page1" class="page" size="A4" layout="landscape">
      <div class="back-page">
        <div class="product-details section">
          <div class="Ref-date">
            <h5 class="top-header">Product Details</h5>
            <div class="irl-ref"><span style="
    width: -webkit-fill-available;
">Ref. no: </span> </div>
          <span style="display:flex; justify-content: space-between;">
            <span> Rd: <span id="refDate"></span> </span>
            <span class="multi_select_box hide-on-pdf" style="display:flex; gap:5px">
              <select
                class="multi_select w-100"
                multiple
                id="rudraksha-select"
                data-selected-text-format="count > 3"
              >
              </select>
              <input type="number" placeholder="No.of same Item" min="1" id="itemsMultiplier"  class="hide-on-pdf" style="border:1px solid coral"/>
            </span>
          </span>
          </div>
          <script>
            const date = new Date();
            let day = date.getDate();
            let month = date.getMonth() + 1;
            let year = date.getFullYear();
            yearsub = (year/1000 + "").split(".")
            day<10 ?  day = '0'+ day : day = day;
            month<10 ?  month = '0'+ month : month = month;
            currentDate = `${day}/${month}/${year-yearsub[0]*1000}`;
            $('#refDate').text(currentDate);
          </script>
          <div class="product">
            <span>Rudraksha(s) Tested:</span>
            <span id="rudTested" class="blue"></span>
            <span>Size Grade:</span>
            <select
              class="grade_select w-100"
              multiple
              id="rudraksha-grade-select"
              data-selected-text-format="count > 3"
            >
              <option contenteditable="true" value="regular">Regular</option>
              <option value="medium">Medium</option>
              <option value="collector">Collector</option>
              <option value="collector">Super Collector</option>
            </select>
            <span>Rudraksha Size:</span>
            <span id="rudCalliper" class="blue" > </span>


            <span>Rudraksha Weight:</span>
            <span id="rudWeight" class="blue"> </span>

            <span>Rudraksha Origin:</span>
            <span class="red" id="rudOrigin">Nepal</span>

            <span>Rudraksha Vendor:</span>
            <span class="blue"> Nepa Rudraksha</span>

            <!-- Test Carried Out -->
            <h5 class="productdetail-title">Test Carried Out:</h5>

            <span>X-ray Test:</span>
            <img class="tick" src="img/tick.png" width="20" alt="" />

            <span>Microscopic Inspection:</span>
            <img class="tick" src="img/tick.png" width="20" alt="" />

            <span>Alien Partical Testing:</span>
            <img class="tick" src="img/tick.png" width="20" alt="" />

            <span>Expert Eye Inspection:</span>
            <img class="tick" src="img/tick.png" width="20" alt="" />

            <span>Vendor Verification:</span>
            <img class="tick" src="img/tick.png" width="20" alt="" />

            <span>Quality Evaluation:</span>
            <img class="tick" src="img/tick.png" width="20" alt="" />

            <span>Durability Evaluation:</span>
            <img class="tick" src="img/tick.png" width="20" alt="" />

            <span>Medically Treated bead:</span>
            <span>No</span>

            <!-- Test Results: -->
            <h5 class="productdetail-title">Test Results:</h5>
            <span>Natural Faces:</span>
            <span class="blue" id="rudraksha-faces"> </span>

            <span>Artificial Faces:</span>
            <span class="blue" >None</span>

            <span>Artificial Fillings:</span>
            <span class="blue" >None</span>

            <span>Risk of Cracking:</span>
            <span class="blue" >Not detected</span>

            <span>Quality Grade:</span>
            <span class="blue" >A+ Grade</span>

            <span>Quality Rating:</span>
            <span>⭐⭐⭐⭐⭐</span>

            <span>Durability Rating:</span>
            <span>⭐⭐⭐⭐⭐</span>

            <span>IRL Expert Rating:</span>
            <span>⭐⭐⭐⭐⭐</span>

            <span>Additional Comment:</span>
            <span class="blue" >Test confirm natural origin and all natural compartments</span>
          </div>
        </div>
        <div class="sec-page section">
          <h5 class="top-header" align="center" style="width:50%">Product Image</h5>
          <div class="products-img" id="productsImg">
           
          </div>
          <div style="font-size:9px; font-family:brela">

            <div class="irl-note" style="width:60%; position:absolute; bottom:0.2cm; right:0.2cm;"><span class="red">Note:</span> All compartments might not be visible to the naked eye on digital x-ray images due to Technical limitations</div>
          </div>
          <!-- <p><img id="output" width="200" /></p> -->

          <script>


    
            var loadFile = function (event, id) {
              var image = document.getElementById(id)
              image.src = URL.createObjectURL(event.target.files[0])

              const ids = ['image-alert', id]
              document.getElementById('upload-msg').style.display = 'none'
              ids.map((a) => {
                document.getElementById(a).style.display = 'block'
              })
            }

            var loadFiles = function (event,id,msg,alert,count) {
              
              var image = document.getElementById(id)
              
              


              image.src = URL.createObjectURL(event.target.files[0])

              const ids = [alert, id]

              if(msg){
                document.getElementById(msg).style.display = 'none'
              } 
            }
          </script>
        </div>
      </div>
    </page>
  </div>
    <button onclick="generatePDF()">Generate PDF</button>

    <script>
      const tx = document.getElementsByTagName("textarea");
      for (let i = 0; i < tx.length; i++) {
        tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
        tx[i].addEventListener("input", textareaStyle, false);
      }

      function textareaStyle() {
        this.style.height = 0;
        this.style.height = (this.scrollHeight) + "px";
        
      }

      $("input[type='text']").css({"border-bottom": "none", "outline":"none"})
      $("button[type='button']").css({"border-bottom": "none", "outline":"none"})
      $(".dropdown-toggle").addClass('generated')

      // This function Generates pdf of the page. Firrst it  convert the webpage to the canvas and read whole page as a image and then further it converts the image to pdf   
      function generatePDF() {
        $("input[type='text']").css({"border-bottom": "none", "outline":"none"})
       $("textarea").css({"border":"none","color":"#2F48A4"})
        $(".scale-input").css({"display": "none"})
        $(".hide-on-pdf").css({"display": "none"})
        $(".upload-msg").css("display","none")
        $(function() {          
            // $('textarea').each(function() {
            //   textareaVal= $(this).val()
            //   $(this).replaceWith($('<span/>').html($(this).html())).val(textareaval);
            // });

            // Loop through each textarea element on the page
$('textarea').each(function() {
  // Create a new span element
  var span = $('<span>', {
    text: $(this).val(), // Set the text content of the span to be the same as the textarea
    // class: $(this).attr('class') // Copy the class attribute from the textarea to the span
  });

  // Replace the textarea with the new span element
  $(this).replaceWith(span);
});

          });
      var opt = {
        margin: 0,
        filename:     'myfile.pdf',
        image:        { type: 'jpeg', quality: 1 },
        html2canvas:  { dpi:900, scale: 3 },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
      };
      var element = document.getElementById('mad');
      html2pdf().from(element).set(opt).toPdf().get('pdf').then(function(pdf) {
        pdf.save()
      });
    }
    
    </script>


<script>
  let tempRudraksha = ["1 Mukhi Savar", "1M Double Savar","1 Mukhi Kaju","1 Mukhi", "2 Mukhi", "3 Mukhi", "4 Mukhi", "5 Mukhi","5 Mukhi","5 Mukhi", "6 Mukhi", "7 Mukhi", "8 Mukhi", "9 Mukhi", "10 Mukhi", "11 Mukhi", "12 Mukhi", "13 Mukhi", "14 Mukhi", "15 Mukhi", "16 Mukhi", "17 Mukhi", "18 Mukhi","19 Mukhi","20 Mukhi", "21 Mukhi", "22 Mukhi", "23 Mukhi", "24 Mukhi",  "25 Mukhi",  "26 Mukhi",  "27 Mukhi", "28 Mukhi", "29 Mukhi",  "30 Mukhi", "Kantha Mala","Japa Mala","Nirakar","Ganesh", "Gaurishankar","Nandi","Trijuti"]
  tempRudraksha.sort(function(a, b) {
  var aNum = parseInt(a);
  var bNum = parseInt(b);
  if (!isNaN(aNum) && !isNaN(bNum)) {
    return aNum - bNum; // sort numerically
  } else {
    return a.localeCompare(b); // sort alphabetically if both don't have numbers
  }
});
  let originRudra=["Nepal"] 
  let stopPop=0;
  // set cookies for the site
  function setCookie(key, value, expiry) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
        }
    
        // get the cookies
        function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        }
    
        // erase the cookies
        function eraseCookie(key) {
          var keyValue = getCookie(key);
          setCookie(key, keyValue, '-1');
        }
        var rudraksha=tempRudraksha
        if(getCookie("rudraitems") > 1 ){
    for(i=1; i<getCookie("rudraitems"); i++){
      rudraksha=rudraksha.concat(tempRudraksha)
      rudraksha.sort(function(a, b) {
        var aNum = parseInt(a);
        var bNum = parseInt(b);
        if (!isNaN(aNum) && !isNaN(bNum)) {
          return aNum - bNum; // sort numerically
        } else {
          return a.localeCompare(b); // sort alphabetically if both don't have numbers
        }
      });
      
    }
    $("#itemsMultiplier").val(getCookie("rudraitems"))
  }else{
    rudraksha=tempRudraksha
  }
  // converts the JSON data to object. 
  
  // to populate the dropdown list of Tested Rudraksha 
  
  rudraksha.map((val) => {
    $('#rudraksha-select').append(`<option value="${val}">
    ${val}
    </option>`)
  })
  
  
  
  // to make the select dropdown box able to select multiple values at a time it uses bootstrap
  $(document).ready(function() {
    $('.multi_select').selectpicker({
      liveSearch: true,
      title:"Select Rudraksha",
      width: "css-width",
    })
    $('.grade_select').selectpicker({
      maxOptions: 1,
      title:"Select Rudraksha Size",
    })
  })
  
  // This is just a alternative for selecting the same element more than once. Its difficult to select the same element more than once in a dropdown so this alternative adds the elementss/products array so same  element is lisited more than once and user can select the elements from the list.
  $("#itemsMultiplier").change(function(){
    eraseCookie("rudraitems")
    setCookie("rudraitems",parseInt($("#itemsMultiplier").val()),1)
    location.reload(true);
  })
  
  
  
  
  // to get the all the Rudraksha selected by the user for further processing
  var kajuOrigin;
  $('#rudraksha-select').change(() => {
    let values = $('#rudraksha-select').val()
    $("#productsImg").empty();
    
    let nonJhapacnt=0;
    let nonKajucnt=0;
    let startPop=1;
    var rudTested=''
    
    values.map((value)=>{
      
      // Replace "Mukhi" with "M" so that while selecting the multiple values, Rudraksha Tested field occupies less space   
      if(rudTested){
        rudTested= rudTested+', '+ value.replace(" Mukhi","M")
      }else{
        rudTested= rudTested+ value.replace(" Mukhi","M")
      }


      if(!value.includes("Japa")){
        nonJhapacnt++
      }

      if(!value.includes("Kaju")){
        nonKajucnt++
      }
      
    })

// To set the origin to Indonsian if japa mala is selected  and give a choice of India or Nepal after the Kaju is selected.
// below code automatically adds Indonesia if jhapa mala is selected whereas it generates a popup with options if kaju is selected.  


    if(rudTested.includes("Japa") || rudTested.includes("Kaju")){        
      // To set the origin to Indonsian if japa mala is selected    
      if(rudTested.includes("Japa")){
        if(nonJhapacnt==0){
          originRudra=["Indonesia"]
        }else{
          if(!originRudra.includes("Indonesia")){
            originRudra.push("Indonesia")
          }
          if(!originRudra.includes("Nepal") && rudTested.includes("Kaju") &&  values.length >= 2){   // This checks if the origin Nepal is present or not while kaju, japa and other rudraksha are selected. 
            originRudra.unshift("Nepal")
          }else if(!originRudra.includes("Nepal") && !rudTested.includes("Kaju") &&  values.length >= 2){   // This checks if the origin Nepal is present or not while kaju, japa and other rudraksha are selected.
            originRudra.unshift("Nepal")
          }
          if(originRudra.includes("Nepal") && rudTested.includes("Kaju") &&  values.length==2){  // This checks if the origin Nepal is present or  while kaju & japa  are selected only selected and removes the Nepal
            originRudra.shift("Nepal")
          }
      }
      }else{
        if(originRudra.includes("Indonesia")){
          originRudra.splice(originRudra.indexOf("Indonesia"),1)
        }
      }

      
      // To set the origin to India/Nepal When Kaju is selected
      //
      if(rudTested.includes("Kaju")){      
        function addIndia(count) {
          if(count==0){
            originRudra=["India(1M Kaju)"]
          }else{

            if(!originRudra.includes("India(1M Kaju)")){ //Avoid the push of "India(1M Kaju)" to originRudra arry, this prevents the duplication of value in Rudraksha Origin field after the kaju is selected
            originRudra.push("India(1M Kaju)")
          }
          }
          $("#rudOrigin").text(originRudra)
          document.getElementById("alert-body").style.display = "none";
        }  
        function popupAlert() {
          document.getElementById("alert-body").style.display = "flex";
        }
        function closepopup() {
          document.getElementById("alert-body").style.display = "none";
  
        }
        
        if(stopPop==0){
          document.getElementById("alert-msg").innerText=`Select the Origin of the 1 Mukhi Kaju Rudraksha`;
          $("#PopupBtn1").text("India").click(()=>addIndia(nonKajucnt))
          $("#PopupBtn2").text("Nepal").click(()=>closepopup())
          popupAlert()      
        }
        stopPop=1;
      }else{
        stopPop=0
        if(originRudra.includes("India(1M Kaju)")){
          originRudra.splice(originRudra.indexOf("India(1M Kaju)"),1)
        }
        if(!originRudra.includes("Nepal") && rudTested.includes("Japa") &&  values.length >= 2){   // This checks if the origin Nepal is present or not while kaju, japa and other rudraksha are selected. 
          originRudra.unshift("Nepal")
        }else if(!originRudra.includes("Nepal") && !rudTested.includes("Japa") &&  values.length >= 2){   // This checks if the origin Nepal is present or not while kaju, japa and other rudraksha are selected.
          originRudra.unshift("Nepal")
        }
        if(originRudra.includes("Nepal") && rudTested.includes("Japa") &&  values.length==2){  // This checks if the origin Nepal is present or  while kaju & japa  are selected only selected and removes the Nepal
          originRudra.shift("Nepal")
        }
        $("#rudOrigin").text(originRudra)
    }

      
    }else {
      stopPop=0
      originRudra=["Nepal"]
    }
    $("#rudTested").text(rudTested)


    $("#rudOrigin").text(originRudra)
     
// End of the automation for Rudraksha origin field

    // to get the no of faces of rudraksha and populate the input box of number of faces
    let faces = ''
    let count = 0 //for productImg
    let cnt = 0 //for singleProduct image
    let openParent = ''
    let gridColn = 0; // to make the product images sit in the grid 
    var columns;
    var rows;
    let elements = "";
    var imgWidth;
    values.map((value) => {
        cnt++
        gridColn++
        if (gridColn == 3) {
            gridColn = gridColn / 3;
        }


        if (values.length == 1) {
            openParent = `<div id="singleProductImg${cnt}" class="products" style="grid-column:1/-1; display: grid; grid-template-columns: 1fr 1fr;">`
            $(`#singleProductImg${cnt}`).empty();
            $('#productsImg').append(openParent)
        } else if (values.length > 6) {
            if (values.length >= 17) {
                columns = "repeat(4,1fr)";
                rows = "repeat(4,1fr)"
                imgWidth = "53px";
            } else if (values.length >= 13) {
                columns = "repeat(4,1fr)";
                rows = "repeat(3,1fr)"
                imgWidth = "68px";
            } else if (values.length >= 10) {
                columns = "repeat(3,1fr)";
                rows = "repeat(4,1fr)"
                imgWidth = "75px";
            } else {
                columns = "repeat(3,1fr)";
                rows = "repeat(3,1fr)"
                imgWidth = "85px";

            }
            if (cnt <= 2) {
                openParent = `<div  id="singleProductImg${cnt}" class="products" style="grid-column:${gridColn}/${gridColn+1}; display: grid; grid-template-columns: ${columns}; grid-template-rows: ${rows};">`
                $('#productsImg').css({
                    "grid-template-colums": "1fr 1fr"
                })
                $('.sec-page').css("justify-content", "flex-start")
                $(`#singleProductImg${cnt}`).empty();
                $('#productsImg').append(openParent)
            }

        } else {
            openParent = `<div  id="singleProductImg${cnt}" class="products" style="grid-column:${gridColn}/${gridColn+1}; display: grid; grid-template-columns: 1fr 1fr;">`
            $(`#singleProductImg${cnt}`).empty();
            $('#productsImg').append(openParent)
        }
        count++



        face = value.match(/\d+/g);
        if(face){
          faces ? faces = faces + ',' + face : faces = face[0];
        }
        imageTypes = ['Front', 'Rear', 'X-Ray', 'Weight']
        if (values.length <= 6) {




            // let prdImgCnt=0;
            imageTypes.map(
                (type) => {
                    count++
                    let id = count + value.replace(/\s/g, '') + Math.floor((Math.random() * 1000) + 1)
                    var frontid = ''

                    frontid = `measurement2`
                    if (count == 2 || count == 7 || count == 10 || count == 14 || count==22 || count==27) {
                        rud = `measurement${count}`
                    }
                    if (type == 'Front') {

                        elements = ` 
                <div style="position:relative; ">
                      <div class="product-image caliper-section" >
                        <input
                          type="file"
                          accept="image/*"
                          name="image"
                          id="${id}Input"
                          onchange="cropperShadow('${id}Input','${id}','${id}-canvas','Front','${count}')"
                          style="display: none"
                        />
                        <canvas id="${id}-canvas" style="display:none"></canvas>          
                        <label for="${id}Input" style="cursor: pointer; position: relative; display:flex; font-size:10px!important; justify-content: flex-start; ">
                          <div id="caliper${count}" class="caliper">
                            <div id="main-scale${count}">                            
                            </div>
                            <img id="vernier-scale${count}" src="calliper/calliper_head.png" />
                            <div class="moveable-jaw" style="z-index: 1000;">
                            <img id="${id}" class="img-${type} front-caliper-img" style=" position: absolute;left: 15.5%;bottom: 2px;">
                              <img id="jaw${count}" style="left: 0%; " src="calliper/jam.png" />
                              <div id="output${count}"></div>
                              <div id="outputoutputSec${count}"></div>
                            </div>
                          </div>
                          <input placeholder="00.00" maxlength="5" type="text" id="measurement${count}" class="scale-input" style="background-color: coral!important; scale:1.2; position: absolute; top:10px; border:1px solid coral; left: 50%; width: 30px; " />
                        </label>
                      </div>
                      <div class="product-label" style="font-size:10px; text-align:center">
                        <span>${value} </span>(${value!="Kantha Mala"? value!="Japa Mala" ? type : "Avg. Bead Size":"Avg. Bead Size"})
                      </div>
                      </div>

                      <style>
                      #caliper${count} {
                        width: 80%;
                        height: 85%;
                        position: relative;
                        // background-color: #ccc;
                          user-select: none;
                      }
                      .generated::after {
                          content: none;
                      }

                      #main-scale${count} {
                        width: 120%;
                        height: 20.5%;
                        position: absolute;
                        top: 27.2%;
                        background: url(calliper/scale1.png);
                        background-size: contain;
                        background-repeat: no-repeat;
                      }

                      #vernier-scale${count} {
                        height: 100%;
                        position: absolute;
                        z-index: 999;
                      }

                      #jaw${count} {
                        height: 100%;
                        position: absolute;
                        bottom: 0;    
                      }

                      .moveable-jaw {
                        width: 100%;
                        height: 100%;
                        position: absolute;
                        bottom: 0;
                      }

                      .scale-tick {
                        position: absolute;
                        bottom: 10px;
                        font-size: 12px;
                        color: transparent;
                        text-align: center;
                      }

                      .scale-tick::before {
                        position: absolute;
                        height: 10px;
                        bottom: -10px;
                        width: 1px;
                        content: '';
                        background: transparent;
                      }

                      .scale-line {
                        position: absolute;
                        bottom: 2px;
                        width: 1px;
                        height: 5px;
                        background-color: transparent;
                      }

                      #caliper${count} input {
                        position: absolute;
                        bottom: -20px;
                        width: 80%;
                      }

                      div#output${count} {
                        position: absolute;
                        top: 30%;
                        height: 15.5%;
                        width: 44.44%;
                        z-index: 99999999;
                      } 
                        </style>
                        `
                        $(`#singleProductImg${cnt}`).append(elements)
                        var caliper = document.getElementById(`caliper${count}`)
                        var parent = document.getElementById(`output${count}`);
                        var jaw = document.getElementById(`jaw${count}`)
                        var input = document.getElementById(`measurement${count}`)

                        var calimg = $(`#${id}`)
                        jaw.style.left = '0'

                        var jawLeft = 0
                        var mouseX = 0
/**
                        jaw.addEventListener('mousedown', function(event) {
                            if (event.button == 0) {
                                jawLeft = parseInt(jaw.style.left)
                                mouseX = event.clientX
                                caliper.addEventListener('mousemove', handleMouseMove)

                            }
                        })

                        jaw.addEventListener('mouseup', function(event) {
                            jaw.style.cursor = 'default'
                            caliper.removeEventListener('mousemove', handleMouseMove)
                        })

                        function handleMouseMove(event) {
                            if (event.buttons == 1) {
                                var newLeft = jawLeft + (event.clientX - mouseX)
                                if (newLeft >= 55) {
                                    newLeft = 55
                                }
                                if (newLeft <= 0) {
                                    newLeft = 0
                                }
                                if (newLeft >= 0) {
                                    // jaw.style.left = newLeft / 1.42 + '%'
                                    jaw.style.left = newLeft / 0.9 + '%'

                                }
                                input.value = newLeft
                                calimg.css({
                                    "width": `${newLeft/0.9}%`
                                })

                                displayNum(newLeft);
                            }
                        }
 */
                        input.addEventListener('change', function() {
                            var value = this.value
                            // here you can define your own conversion from input to pixels
                            // jaw.style.left = value / 1.42 + '%'\

                            let id = this.id
                            var elementId = id.match(/(\d+)/);
                            jaw.style.left = value / 0.9 + '%'
                            calimg.css({
                                "width": `${value/0.9}%`,
                                "min-height": "auto"
                            })

                            $(`#rud${parseInt(elementId)+3}`).css({
                                "width": `${parseInt(value) + 7}%`
                            })

                            displayNum(value);
                        })


                        // this is to display the number on  calliper display 
                        const displayNum = (value) => {

                            while (parent.firstChild) {
                                parent.removeChild(parent.firstChild);
                            }
                            var counter = 0;
                            var numberString = value.toString();
                            var inputArray = numberString.split('');
                            for (var i = 0; i < inputArray.length; i++) {
                                if (inputArray[i] === '.') {
                                    var counter = 1;
                                }
                            }


                            if (counter) {
                                var numbers = numberString.split('.');
                                if (numbers[0]) {
                                    var number = numbers[0];
                                } else {
                                    number = '0';

                                }
                                var decimal = numbers[1];
                            } else {
                                var numbers = value.toString();
                                var number = numbers;
                                var decimal = '00';
                            }

                            if (number.split('').length == 1) {
                              if(values.length==1){
                                parent.style.paddingLeft = "6.53%";
                              }else if(values.length==2){                                
                                parent.style.paddingLeft = "6%";
                              }else{
                                parent.style.paddingLeft = "6.25%";
                              }
                            }
                            var numberArray = number.split('');
                            if (decimal.split('').length == 1) {
                                decimal = decimal + "0";
                            }
                            var decimalArray = decimal.split('');

                            const convertNumber = (digit) => {
                                img.style.height = '85%';
                                img.style.display = 'inline-block';

                                if (digit[i] === '1') {
                                    img.setAttribute('src', 'calliper/1.png');
                                } else if (digit[i] === '2') {
                                    img.setAttribute('src', 'calliper/2.png');
                                } else if (digit[i] === '3') {
                                    img.setAttribute('src', 'calliper/3.png');
                                } else if (digit[i] === '4') {
                                    img.setAttribute('src', 'calliper/4.png');
                                } else if (digit[i] === '5') {
                                    img.setAttribute('src', 'calliper/5.png');
                                } else if (digit[i] === '6') {
                                    img.setAttribute('src', 'calliper/6.png');
                                } else if (digit[i] === '7') {
                                    img.setAttribute('src', 'calliper/7.png');
                                } else if (digit[i] === '8') {
                                    img.setAttribute('src', 'calliper/8.png');
                                } else if (digit[i] === '9') {
                                    img.setAttribute('src', 'calliper/9.png');
                                } else if (digit[i] === '0') {
                                    img.setAttribute('src', 'calliper/0.png');
                                }

                            }

                            for (var i = 0; i < numberArray.length; i++) {

                                var img = document.createElement('img');
                                convertNumber(numberArray);
                                parent.appendChild(img);

                            }

                            for (var i = 0; i < decimalArray.length; i++) {

                                var img = document.createElement('img');
                                convertNumber(decimalArray);
                                parent.appendChild(img);

                            }

                            if (values.length == 1) {
                                $('#output2').css("top", '31.5%')
                                parent.style.left = value / 0.9 + 31.8 + '%'
                            } else {
                                parent.style.left = value / 0.9 + 32.3 + '%'
                                if (values.length == 2) {
                                    parent.style.left = value / 0.9 + 32.7 + '%'
                                    parent.style.top = "30.25%";
                                }
                                if (values.length >4) {
                                    parent.style.top = "30%";                                    
                                }
                            }
                            
                            // console.log("parent 2 ko test" + parent2)
                            parent2.style.left = value / 0.9 + 27.5 + '%'

                            if (numberArray.length <= 1) {
                                parent.style.paddingLeft = "13%";
                            }
                            if (numberArray.length > 1) {
                                parent.style.paddingLeft = "6.5%";

                            }



                        }


                    } else if (type == 'Weight') {
                        elements = ` 
                        <div style="position:relative;">
                          <div class="product-image">
                            <input
                              type="file"
                              accept="image/*"
                              name="image"
                              id="${id}Input"
                              onchange="cropperShadow('${id}Input','rud${count}','rud-canvas${count}','Weight','${count}')"
                              style="display: none"
                            />
                            <canvas id="rud-canvas${count}" style="display:none"></canvas> 
                            <label for="${id}Input" style="cursor: pointer; position: relative; display:flex; font-size:10px!important; justify-content: center; ">
                              <div class="moveable-jaw" style="display:flex; width:auto; ">
                                  
                                  ${value=="Japa Mala" 
                                    ? `<img id="weight${count}" style="left: 0%;" src="" /><span class="upload-msg" id="upload-msg${count}" style="z-index: 1; width: max-content"> Upload Image</span><img id="rud${count}" class="japa-weight" src style=" position: absolute; height: 100%!important; min-height:auto;"/>` 
                                    : `<img id="weight${count}" style="left: 0%;" src="weight/weight.png" /><img id="rud${count}" class="rudrakshaWeight" src style=" position: absolute; height: auto; min-height:auto;"/><div id="output${count}" style="position: absolute; left: 21px; bottom: 12px;"></div>
                                  <div id="outputSec${count}"></div>`}
                                  
                                  
                              </div>
                              <input placeholder="00.00" maxlength="5" type="text" id="wghtmeasurement${count}" class="weight-input hide-on-pdf" style="scale:1.2; position: absolute; background-color: coral!important; top:3px; border:1px solid coral; left: 50%; translate: -50%; width: 30px; " />
                            </label>
                          </div>
                          <div class="product-label" style="font-size:10px; text-align:center">
                            <span>${value}</span>(${value!="Kantha Mala"? value!="Japa Mala" ? type : "Weight":"Avg. Bead Wt."})
                          </div>
                          </div>`


                        var element_style = `
                          <style>
                          #output${count}{
                            height: 13.5%!important;
                            display: flex;
                            min-height: auto;
                            left: 31.25%!important;
                            align-items: center;
                            bottom: 22%!important;
                          }

                          .japa-weight{
                            width:auto!important;
                          }

                          .moveable-jaw{
                            justify-content:center;
                          }
                          </style>
                      `


                        $(`#singleProductImg${cnt}`).append(elements)
                        $(`#singleProductImg${cnt}`).append(element_style)
                        var wghtparent = document.getElementById(`output${count}`);
                        var wghtparent2 = document.getElementById(`outputSec${count}`);
                        var wghtjaw = document.getElementById(`weight${count}`)
                        var wghtinput = document.getElementById(`wghtmeasurement${count}`)
                        wghtjaw.style.left = '0'
                        var wghtjawLeft = 0



                        wghtinput.addEventListener('change', function() {
                            var value = this.value
                            displayNum(value);
                            // wghtjaw.style.left =  '50%'
                        })

                        // this function displays the number on the screen of weigth machine
                        const displayNum = (value) => {

                            while (wghtparent.firstChild) {
                                wghtparent.removeChild(wghtparent.firstChild);
                            }
                            var counter = 0;
                            var numberString = value.toString();
                            var inputArray = numberString.split('');
                            for (var i = 0; i < inputArray.length; i++) {
                                if (inputArray[i] === '.') {
                                    var counter = 1;
                                }
                            }


                            if (counter) {
                                var numbers = numberString.split('.');
                                if (numbers[0]) {
                                    var number = numbers[0];
                                } else {
                                    number = '0';

                                }
                                var decimal = numbers[1];
                            } else {
                                var numbers = value.toString();
                                var number = numbers;
                                var decimal = '0';
                            }

                            var numberArray = number.split('');
                            // if (decimal.split('').length == 1) {
                            //     // decimal = decimal + "0";
                            // }
                            var decimalArray = decimal.split('');

                            const convertNumber = (digit) => {
                                img.style.height = '90%';
                                img.style.display = 'inline-block';
                                // img.style.marginRight = '2px';

                                if (digit[i] === '1') {
                                    img.setAttribute('src', 'weight/1.png');
                                } else if (digit[i] === '2') {
                                    img.setAttribute('src', 'weight/2.png');
                                } else if (digit[i] === '3') {
                                    img.setAttribute('src', 'weight/3.png');
                                } else if (digit[i] === '4') {
                                    img.setAttribute('src', 'weight/4.png');
                                } else if (digit[i] === '5') {
                                    img.setAttribute('src', 'weight/5.png');
                                } else if (digit[i] === '6') {
                                    img.setAttribute('src', 'weight/6.png');
                                } else if (digit[i] === '7') {
                                    img.setAttribute('src', 'weight/7.png');
                                } else if (digit[i] === '8') {
                                    img.setAttribute('src', 'weight/8.png');
                                } else if (digit[i] === '9') {
                                    img.setAttribute('src', 'weight/9.png');
                                } else if (digit[i] === '0') {
                                    img.setAttribute('src', 'weight/0.png');
                                }
                            }

                            for (var i = 0; i < numberArray.length; i++) {
                                var img = document.createElement('img');
                                convertNumber(numberArray);
                                wghtparent.appendChild(img);
                            }

                            for (var i = 0; i < decimalArray.length; i++) {
                                var img = document.createElement('img');
                                convertNumber(decimalArray);
                                wghtparent.appendChild(img);
                            }



                            wghtparent.style.left = value / 0.9 + 25.25 + '%'

                            if (numberArray.length <= 1) {
                                wghtparent.style.paddingLeft = "10%";
                            }
                            if (numberArray.length > 1) {
                                wghtparent.style.paddingLeft = "2%";
                            }



                        }
                    } else {

                        elements = ` <div><div class="product-image"><input
                type="file"
                    accept="image/*"
                    name="image"
                    id="${id}Input"
                    onchange="cropperShadow('${id}Input','${id}','canvas${id}','Other','${count}')"
                    style="display: none"
                  />
                  <canvas id="canvas${id}" style="display:none"></canvas> 
                  <label ${type == "Rear" ? 'style="scale:0.6; display: flex; justify-content: center;"' : null } for="${id}Input" style="cursor: pointer; position: relative; display:flex; font-size:10px!important">
                      <span class="upload-msg" id="upload-msg${count}" style="z-index: 1; width: max-content">
                        Upload Image
                      </span>                    
                      <img id="${id}" class="img-${type}"  style="${type == "Rear" ? "scale:0.56; display: none;":"display: none;"}"/>
                      <span class="image-alert" id="image-alert${count}" style="display: none">
                        Click Here to change the Image
                      </span>
                  </label></div>
                  <div class="product-label" style="font-size:10px; text-align:center">             
                  <span>${value} </span>(${value=="Kantha Mala" || value=="Japa Mala"? type=="Rear" ? "Beads" : type : type})
                  </div></div>`
                        $(`#singleProductImg${cnt}`).append(elements)

                    }
                })
        } else {
            null
        }


    })
    if(values.length>6){

    for(i=1;i<=2;i++){
      count++
    values.map((value) => {
        count++
        let id = count + value.replace(/\s/g, '') + Math.floor((Math.random() * 1000) + 1)+i
        elements = ` <div class="products">
          <div><input
                type="file"
                    accept="image/*"
                    name="image"
                    id="${id}Input"
                    onchange="cropperShadow('${id}Input','${id}','canvas${id}','Other','${count}')"
                    style="display: none"
                  />
                  <canvas id="canvas${id}" style="display:none"></canvas> 
                  <label  for="${id}Input" style="cursor: pointer; position: relative; display:flex; font-size:10px!important">
                      <span class="upload-msg" id="upload-msg${count}" style=" font-size:8px; z-index: 1; width: max-content">
                        Upload Image
                      </span>                    
                      <img id="${id}" class="moreproduct" style="display: none" />
                      <span class="image-alert" id="image-alert${count}" style="display: none">
                        Click Here to change the Image
                      </span>
                  </label>
                  </div>
                  <div contenteditable="true" style="font-size:9px; text-align:center; ${value.replace(" Mukhi","M").length<=8?"display: flex;":""}
    text-align: center;
    flex-wrap: nowrap;
    align-items: flex-start;"><span style="display:flex; justify-content: center; gap: 2px; align-content: center; align-items: center;">${value.replace(" Mukhi","M")}</span><span style="display: flex; justify-content: center; gap: 2px; align-content: center; align-items: center;">(<textarea class="gmsInput" value="0" maxlength="5" style="font-size:9px!important; color:#000000!important; max-width:28px; margin-top:-1.5px;" type="text">0</textarea> ${i==1? "mm" : "gms"})</span></div></div>`

        $(`#singleProductImg${i}`).append(elements)
    })
  }
  }
    $('#rudraksha-faces').text(faces)
    if (values.length == 2) {
        rowrepeat = 1
        labelscale = "1"
        labelheight = "108px"
        imgwidth = "100%"
    } else if (values.length >= 3 && values.length <= 4) {
        repeat = 2        
        labelscale = "0.8"
        labelheight = "107px"
        $(".product-image").css({"margin-bottom":"-7%"})
        $(".product-label").css({"scale":"1.1","margin-bottom":"-5%"})
      } else if (values.length >= 5 && values.length <= 6) {
        repeat = 3
        labelscale = "0.63"
        $(".product-image").css({"margin-top":"-14%"})
        $(".product-label").css({"scale":"1","margin-top":"-17%"})
        $(".top-header").css("margin-top","-2%")
        $(".products-img").css("row-gap","4px")
        $(".irl-note").css({"bottom":"0.05cm"})
                         
      } else if (values.length >= 6 && values.length <= 17) {
        labelscale = "0.9"                         
    } else if (values.length >= 18 && values.length <= 20) {
        labelscale = "0.85"                         
    } else {
        labelheight = "220px"
        labelscale = "0.7"
        imgwidth = "100%"
        $(".product-label").css({"translate": "0 -250%"})

    }
    if (values.length == 1) {
        $('#productsImg').css("grid-template-columns", `repeat(1,1fr)`)
    } else {
        $('#productsImg').css({
            "grid-template-columns": `repeat(2,1fr)`,
            "grid-template-rows": `repeat(${rowrepeat},1fr)`
        })
    }
    $(".product-image").css({"height": labelheight})
    $("#productsImg").css({ "translate":` ${values.length>2? values.length>6? "0% 0%":"0% -5%" : "0% -10%" }` })
    $('#productsImg label').css({
        "height": labelheight,
        "scale":labelscale,
        // "scale":`${values.length<2? "0.9" : "" }`,
        "overflow": "hidden"
    })
    $('#productsImg .products label').css({
      "height": imgWidth,
      "width": imgWidth,

        "overflow": "hidden"
    })
    $('#productsImg img').css({
      "width": "auto",
      "height": imgwidth
    })
    $('#productsImg .products label img').css({
      "width": "auto",
      "height": "85%"
    })

    $(`.caliper img`).css({
        "width": "auto",
        "height": "auto"
    })

 
    // To calculate total weight of rudraksha by adding the individual weight rudraksha weight and displaying the total weight  in Rudraksha Weight: portion 
    var productsDetailClass = ["#singleProductImg2 .gmsInput", ".scale-input", ".weight-input", "#rudraksha-grade-select"]    
    productsDetailClass.map((productClass)=>(          
      $(productClass).change(function() {
        let total=0
        $(productClass).each(function() {
          
          if(values.length>6){
            if($(this).val()){  
              total=total + parseFloat($(this).val());
            }
          }else{
            if($(this).val() && total){  
              total=total +', '+$(this).val();
            }else{
              total=$(this).val();
            }
          }
          });
          
          let unit = `${productClass==".scale-input" ? " mm" : " gms"}`
          if(productClass==".scale-input" || productClass=="#rudraksha-grade-select"){
            if(values.length>6){
              let sizevalue = $('[data-id="rudraksha-grade-select"] .filter-option-inner-inner').text()
              $("#rudCalliper").text(sizevalue)
            }else{
             if(typeof total == "string"){

                $("#rudCalliper").text(total + unit)
              }
            }
          }else{
            $("#rudWeight").text(total + unit)
          }
        })
      ))

  

    // it makes the size grade dropdown dependable to the Rudraksha tested so the user will not be able to select the size more than the rudraksha selected  
    $('.grade_select').selectpicker({
        maxOptions: values.length,
    })


    // to get the no. of  rudraksha selected by the user
    if (values.length) {
        $('.grade_select').selectpicker({
            maxOptions: values.length,
        })
    }

    if(values.length>6){    

    // Get the input value from calliper and automate the value in Rudraksha Size
    $("#rudraksha-faces").text("All Natural Faces")
    $(`#singleProductImg1`).css("padding","0 5px")
    $(`#singleProductImg2`).css("padding","0 5px")
    $("#productsImg").append(`<style>
    img.moreproduct {
        max-width: 50px!important;
        height:auto!important;
        max-height: 50px!important;
    }
    </style>`)

}


})


    // <!-- For Cropping Image and adding shadow to images for making it look real  -->
    
    
    function cropperShadow (cropInput,cropImage,cropCanvas,type,counter) {
      let fileInput = document.getElementById(cropInput)
      let croppedCanvas = document.getElementById(cropCanvas)
      let croppedImage = document.getElementById(cropImage)
      document.getElementById(cropImage).style.display = 'block'

      const counterArry=["2","5","7","10","12","15", "17","20","22","25","27","30"]
      if(!counterArry.includes(counter)){
        document.getElementById(`upload-msg${counter}`).style.display = 'none'
      }
      
      let file = fileInput.files[0];
      let reader = new FileReader();

      reader.addEventListener('load', () => {
        const img = new Image();
        img.src = reader.result;

        img.addEventListener('load', () => {
          // Create a canvas element
          const canvas = document.createElement('canvas');
          canvas.width = img.width;
          canvas.height = img.height;
          const ctx = canvas.getContext('2d');
          
          // Draw the image onto the canvas
          ctx.drawImage(img, 0, 0, img.width, img.height);
          
          // Get the image data
          const imageData = ctx.getImageData(0, 0, img.width, img.height);
          const pixels = imageData.data;

          // Find the boundaries of the non-transparent pixels
          let left = img.width;
          let right = 0;
          let top = img.height;
          let bottom = 0;

          for (let y = 0; y < img.height; y++) {
            for (let x = 0; x < img.width; x++) {
              const i = (y * img.width + x) * 4;
              const alpha = pixels[i + 3];
              if (alpha > 0) {left = Math.min(left, x);
                right = Math.max(right, x);
                top = Math.min(top, y);
                bottom = Math.max(bottom, y);
              }
            }
          }
            
          // Crop the image to the non-transparent portion
          if(type!="Weight"){
            const croppedWidth = right - left;
            const croppedHeight = bottom - top;
            croppedCanvas.width = croppedWidth;
            croppedCanvas.height = croppedHeight;
            const croppedCtx = croppedCanvas.getContext('2d');
            croppedCtx.drawImage(img, left, top, croppedWidth, croppedHeight, 0, 0, croppedWidth, croppedHeight);
          } else{
            
            const croppedWidth = right - left;
            const croppedHeight = bottom - top;
            croppedCanvas.width = croppedWidth;
            croppedCanvas.height = croppedHeight;
            const croppedCtx = croppedCanvas.getContext('2d');
            // Apply drop shadow to the canvas
            croppedCtx.shadowOffsetX = 15;
            croppedCtx.shadowOffsetY = 15;
            croppedCtx.shadowBlur = 25;
            croppedCtx.shadowColor = 'rgba(112,112,112,1)';
            croppedCtx.drawImage(img, left, top, croppedWidth+35, croppedHeight+25, 0, 0, croppedWidth, croppedHeight);
          }

          ctx.shadowBlur = 15;
          ctx.shadowColor = 'red';

          // Update the image element
          croppedImage.src = croppedCanvas.toDataURL();


          
        });

      });

      reader.readAsDataURL(file);
    }

    

  </script>
  <style>
    div[style="font-size:10px; text-align:center"] {
    scale: 1.1;
}
  </style>
</html>
