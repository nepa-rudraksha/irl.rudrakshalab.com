<?php
$conn = mysqli_connect('localhost','root','','user_db');

            $sql= "SELECT DISTINCT rudraksha FROM data_entry";
            $result=mysqli_query($conn,$sql);
            $json_array = array();
            while($row = mysqli_fetch_assoc($result))
            {
              $json_array[]=$row; // Since I used array of objects as a dummy data so i converted the datas to json format then later in below is converted to array of object
            }
?>

<!DOCTYPE html>
<html>
  <head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"
    />

    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
       <page class="page" size="A4" layout="landscape">
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
              id="urls"
              onchange="removebackground(event)"
              style="display: none"
            />

            <label for="urls" style="cursor: pointer; position: relative">
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
            <img src="img/signature.svg" alt="signature" width="75.6" />
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
                and it is strongly prohibited to use IRL’s name or logo without
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
              <span>Pingalsthan Gushala - 9, Kathmandu,Nepal </span
              ><span>Ph: +977 1 5241176 </span>
            </div>
          </div>
        </center>


        <!-- Front page or the cover page of IRL report -->
        <div class="section cover-page">
          <span class="horizontal-text">
            INternational Rudraksha laboratory
          </span>

          <!-- IRL logo portion -->
          <center>
            <div class="irl-logo">
              <img src="img/Irl-logo.svg" height="35" alt="irl logo" />
              <h1>IRL</h1>
              <b class="irl-logo-r">®</b>
            </div>
            <div class="cover-page-certification">
              <img
                class="cover-page-rudraksha"
                src="img/rudrasha.svg"
                height="80"
                alt="Rudraksha"
              />
              <div class="certification">
                <img src="img/iso.svg" height="35" alt="Iso" />
                <img src="img/iaf.svg" width="35" alt="Iso" />
                <img src="img/jas-anz.svg" height="35" alt="Iso" />
              </div>
              <div class="cover-page-footer">
                WORLD’S OnlY RUDRAKSHA - sPECIFIC LABORATORY
              </div>
            </div>
          </center>
        </div>
      </div>
    </page>
    <page class="page" size="A4" layout="landscape">
      <div class="back-page">
        <div class="product-details section">
          <div class="Ref-date">
            <h5>Product Details</h5>
            <span>Ref. no : 20302130389 </span>
            <span>Ref. no : 20302130389 </span>
          </div>
          <div class="product">
            <span>Rudraksha(s) Tested:</span>
            <span class="multi_select_box">
              <select
                class="multi_select w-100"
                multiple
                id="rudraksha-select"
                data-selected-text-format="count > 3"
              ></select>
            </span>

            <span>Rudraksha Size:</span>
            <input type="text" />

            <span>Size Grade:</span>
            <select
              class="grade_select w-100"
              multiple
              id="rudraksha-grade-select"
              data-selected-text-format="count > 3"
            >
              <option value="regular">Regular</option>
              <option value="medium">Medium</option>
              <option value="collector">Collector</option>
            </select>

            <span>Rudraksha Weight:</span>
            <input type="text" />

            <span>Rudraksha Origin:</span>
            <input type="text" value="Nepal" />

            <span>Rudraksha Vendor:</span>
            <input type="text" value="Nepa Rudraksha" />

            <!-- Test Carried Out -->
            <h5 class="productdetail-title">Test Carried Out:</h5>

            <span>X-ray Test:</span>
            <img class="tick" src="img/tick.svg" width="20" alt="" />

            <span>Microscopic Inspection:</span>
            <img class="tick" src="img/tick.svg" width="20" alt="" />

            <span>Alien Partical Testing:</span>
            <img class="tick" src="img/tick.svg" width="20" alt="" />

            <span>Expert Eye Inspection:</span>
            <img class="tick" src="img/tick.svg" width="20" alt="" />

            <span>Vendor Verification:</span>
            <img class="tick" src="img/tick.svg" width="20" alt="" />

            <span>Quality Evaluation:</span>
            <img class="tick" src="img/tick.svg" width="20" alt="" />

            <span>Durability Evaluation:</span>
            <img class="tick" src="img/tick.svg" width="20" alt="" />

            <span>Medically Treated bead:</span>
            <span>No</span>

            <!-- Test Results: -->
            <h5 class="productdetail-title">Test Results:</h5>
            <span>Natural Faces:</span>
            <input type="text" id="rudraksha-faces" />

            <span>Artificial Faces:</span>
            <input type="text" value="None"/>

            <span>Artificial Fillings:</span>
            <input type="text" value="None"/>

            <span>Risk of Cracking:</span>
            <input type="text" value="Not detected"/>

            <span>Quality Grade:</span>
            <input type="text" value="A+ Grade"/>

            <span>Quality Rating:</span>
            <input type="text" value="⭐⭐⭐⭐⭐"/>

            <span>Durability Rating:</span>
            <input type="text" value="⭐⭐⭐⭐⭐"/>

            <span>IRL Expert Rating:</span>
            <input type="text" value="⭐⭐⭐⭐⭐"/>

            <span>Additional Comment:</span>
            <span
              >Test confirm natural origin and all natural compartments</span
            >
          </div>
        </div>
        <div class="sec-page section">
          <h5 align="center">Product Image</h5>
          <div class="products-img" id="productsImg">
           
          </div>
          <div style="font-size:9px; font-family:brela">

            <div style="width:285px; position:absolute; bottom:0.2cm; right:0.2cm;"><span>Note:</span> All compartments might not be visible to the naked eye on digital x-ray images due to echnical limitations</div>
          </div>
          <!-- <p><img id="output" width="200" /></p> -->

          <script>
    var removebackground = function (event) {
        // let images = '["'+document.getElementById('urls').value+'"]'
        let image = document.getElementById(id)

        image.src = URL.createObjectURL(event.target.files[0])
        images= URL.createObjectURL(event.target.files[0])
        
        // let images ="file:///C:/Users/Admin/Desktop/13s.png"
        console.log(images);
     
        images.forEach(imageUrl => {
            const image = new Image();
            image.onload = ({ target }) => {
                const w = Math.round(target.width);
                const h = Math.round(target.height);

                const canvas = document.createElement("canvas");
                canvas.width = w;
                canvas.height = h;
                const canvasContext = canvas.getContext("2d");
                canvasContext.drawImage(
                    target,
                    0,
                    0,
                    target.width,
                    target.height,
                    0,
                    0,
                    w,
                    h
                );

                const canvasImageData = canvasContext.getImageData(0, 0, w, h);

                for (
                    let index = 0, dataLength = canvasImageData.data.length;
                    index < dataLength;
                    index += 4
                ) {
                    const r = canvasImageData.data[index];
                    const g = canvasImageData.data[index + 1];
                    const b = canvasImageData.data[index + 2];
                    if ([r, g, b].every((item) => item > 230))
                        canvasImageData.data[index + 3] = 0;
                }

                target.width = w;
                target.height = h;
                canvasContext.putImageData(canvasImageData, 0, 0);
                document.body.append(image, canvas);
            };
            image.crossOrigin = "";
            image.src = images;
        });
    }
</script>
          <script>

            
            var loadFile = function (event, id) {
              var image = document.getElementById(id)
              image.src = URL.createObjectURL(event.target.files[0])


              const ids = ['image-alert', id]
              document.getElementById('upload-msg').style.display = 'none'
              ids.map((a) => {
                document.getElementById(a).style.display = 'block'
                console.log(a)
              })
            }

            var loadFiles = function (event, id,msg,alert) {
              var image = document.getElementById(id)
              image.src = URL.createObjectURL(event.target.files[0])

              const ids = [alert, id]
              document.getElementById(msg).style.display = 'none'
              
              ids.map((a) => {
                document.getElementById(a).style.display = 'block'
                console.log(a)
              })
            }
          </script>
        </div>
      </div>
    </page>

    <button onclick="window.print();" class="btn btn-primary" id="print-btn">
      Print
    </button>
  </body>

  <!-- for multi select with search feature dropdown box -->
  <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.js"
  ></script>
  <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"
  ></script>
  <script>
  
  // converts the JSON data to object. 
  const rudraksha = JSON.parse('<?php echo json_encode($json_array);?>')
  console.log(rudraksha)

    // to populate the dropdown list of Tested Rudraksha 
    rudraksha.map((val) => {
      $('#rudraksha-select').append(`<option value="${val.rudraksha}">
          ${val.rudraksha}
          </option>`)
    })


    // to make the select dropdown box able to select multiple values at a time it uses bootstrap
    $(document).ready(function () {
      $('.multi_select').selectpicker({
        liveSearch: true,
      })
      $('.grade_select').selectpicker({
        maxOptions: 1,
      })
    })


    // to get the all the Rudraksha selected by the user for further processing
    $('#rudraksha-select').change(() => {
      let values = $('#rudraksha-select').val() 
      
      $("#productsImg").empty();
      // to get the no of faces of rudraksha and populate the input box of number of faces
      let faces=''
      let count=0
      
      values.map((value)=>{
        
        face=value.match(/\d+/g);
        faces ? faces=faces+','+face : faces=face;
        count++
        imageTypes=['Front','Rear','X-Ray','Weight']
        imageTypes.map(
          (type)=>{
            count++
            let id=count+value.replace(/\s/g, '')+Math.floor((Math.random() * 1000) + 1)
            console.log(id)
              let elements =` <div><div><input
                  type="file"
                  accept="image/*"
                  name="image"
                  id="${id}Input"
                  onchange="loadFiles(event,'${id}','upload-msg${count}','image-alert${count}')"
                  style="display: none"
                />
    
                <label for="${id}Input" style="cursor: pointer; position: relative; display:flex; font-size:10px!important">
                  <span class="upload-msg" id="upload-msg${count}" style="z-index: 1; width: max-content"
                    >Upload Image</span
                  >
                  <img id="${id}"  style="display: none" />
                  <span class="image-alert" id="image-alert${count}" style="display: none"
                    >Click Here to change the Image</span
                  >
                </label></div><div style="font-size:12px; text-align:center"><span>${value}</span>(${type})</div></div>`

              $('#productsImg').append(elements)

            }
          )
}
)

      $('#rudraksha-faces').val(faces)
      $('#productsImg').css("grid-template-columns",`repeat(${values.length*2},1fr)`)



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
    })
  </script>
</html>
