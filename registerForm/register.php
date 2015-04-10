<?

require_once "JoomInc.php";
require_once "administrator/components/com_comprofiler/plugin.foundation.php";
$doc =& JFactory::getDocument();
$doc->addStyleSheet( 'style.css' );
$document->addScript('http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js');

		$cbSpoofString			=	cbSpoofString( null, 'registerForm' );
		
		$regAntiSpamValues		=	cbGetRegAntiSpams();

?>

<!--<p id="errorMsg">We're sorry, but registration is temporarily disabled due to technical difficulties. We are working tirelessly to resolve the issue. Please check back soon!</p>-->

<div style="/*-webkit-filter: blur(2px);-moz-filter: blur(2px);-o-filter: blur(2px);-ms-filter: blur(2px);filter: blur(2px);pointer-events: none;*/">
<form action="/index.php/component/comprofiler/" method="post" name="adminForm" id="register" enctype="multipart/form-data">
	<div id="register">
		<div class="genBox" >
		<span style="text-shadow: 1px 1px 5px white;"> Step 1: Register for your FREE month</span>
		</div>

		<div class="genBox2" style="margin:0px 0px 40px 0px;">
			
			<div class="inline"> 	
				<div class="block"> First name </div>
				<div class="block"> <input type="text" required name="firstname" id="firstname" style="width:198px;"/> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>	
			<div class="inline"> 	
				<div class="block"> Last name </div>
				<div class="block"> <input type="text" required name="lastname" id="lastname" style="width:198px;" /> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>	
			<div class="inline" > 	
				<div class="block"> Email  </div>
				<div class="block" > <input type="email" required name="email" id="email" style="width:198px;" /> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>	

			<div class="inline" style="margin:0px 0px 20px 0px;"> 	
				<div class="block"> Verify email </div>
				<div class="block"> <input type="text" required name="username" id="username" style="width:198px;" /> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>	
			<div class="inline"> 	
				<div class="block" style="font-weight:bold;"> Choose a Password (6 or more characters) </div>
				<div class="block"> <input type="password" required name="password" id="password" size="45"/> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>	
			<div class="inline" style="margin:0px 0px 20px 0px;"> 	
				<div class="block" style="font-weight:bold;"> Verify password  </div>
				<div class="block" > <input type="password" required name="password__verify" id="password__verify" size="45"/> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>	
			<div class="inline"> 	
				<div class="block"> Address 1 </div>
				<div class="block"> <input type="text" required name="cb_saddress1" id="cb_saddress1" size="49"/> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>	
			<div class="inline" style="margin:0px 0px 20px 0px;"> 	
				<div class="block"> Address Line 2 (optional)</div>
				<div class="block"> <input type="text" name="cb_saddress2" id="cb_saddress2" size="49"/> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>	
			<div class="inline" > 	
				<div class="block"> City  </div>
				<div class="block" > <input type="text" required name="cb_scity" id="cb_scity" size="45"/> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>	

			<div class="inline" > 	
				<div class="block"> State </div>
				<div class="block"> 
					<select name="cb_sstate" id="cb_sstate">
						<option value=""> </option>
						<option value="AL" id="cbf95">AL</option>
						<option value="AK" id="cbf96">AK</option>
						<option value="AZ" id="cbf97">AZ</option>
						<option value="AR" id="cbf98">AR</option>
						<option value="CA" id="cbf99">CA</option>
						<option value="CO" id="cbf100">CO</option>
						<option value="CT" id="cbf101">CT</option>
						<option value="DC" id="cbf102">DC</option>
						<option value="DE" id="cbf103">DE</option>
						<option value="FL" id="cbf104">FL</option>
						<option value="GA" id="cbf105">GA</option>
						<option value="HI" id="cbf106">HI</option>
						<option value="ID" id="cbf107">ID</option>
						<option value="IL" id="cbf108">IL</option>
						<option value="IN" id="cbf109">IN</option>
						<option value="IA" id="cbf110">IA</option>
						<option value="KN" id="cbf111">KN</option>
						<option value="KY" id="cbf112">KY</option>
						<option value="LA" id="cbf113">LA</option>
						<option value="ME" id="cbf114">ME</option>
						<option value="MY" id="cbf115">MY</option>
						<option value="MA" id="cbf116">MA</option>
						<option value="MI" id="cbf117">MI</option>
						<option value="MN" id="cbf118">MN</option>
						<option value="MS" id="cbf119">MS</option>
						<option value="MO" id="cbf120">MO</option>
						<option value="MT" id="cbf121">MT</option>
						<option value="NE" id="cbf122">NE</option>
						<option value="NV" id="cbf123">NV</option>
						<option value="NH" id="cbf124">NH</option>
						<option value="NJ" id="cbf125">NJ</option>
						<option value="NM" id="cbf126">NM</option>
						<option value="NY" id="cbf127">NY</option>
						<option value="NC" id="cbf128">NC</option>
						<option value="ND" id="cbf129">ND</option>
						<option value="OH" id="cbf130">OH</option>
						<option value="OK" id="cbf131">OK</option>
						<option value="OR" id="cbf132">OR</option>
						<option value="PA" id="cbf133">PA</option>
						<option value="RI" id="cbf134">RI</option>
						<option value="SC" id="cbf135">SC</option>
						<option value="SD" id="cbf136">SD</option>
						<option value="TN" id="cbf137">TN</option>
						<option value="TX" id="cbf138">TX</option>
						<option value="UT" id="cbf139">UT</option>
						<option value="VT" id="cbf140">VT</option>
						<option value="VA" id="cbf141">VA</option>
						<option value="WA" id="cbf142">WA</option>
						<option value="WV" id="cbf143">WV</option>
						<option value="WI" id="cbf144">WI</option>
						<option value="WY" id="cbf145">WY</option>
						<option value="MD" id="cbf146">MD</option>
					</select>
				</div>
			</div>	
			<div class="inline" style="margin:0px 0px 20px 0px;"> 	
				<div class="block" style="font-weight:bold;"> ZIP  </div>
				<div class="block" > <input type="text" required name="cb_szip" id="cb_szip" size="45"/> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>
			<div class="inline"> 	
				<div class="block"> Parental Pin (4 digits) </div>
				<div class="block"> <input type="password" required name="cb_pin" id="cb_pin" size="22"/> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>	
			<div class="inline" > 	
				<div class="block"> Verify Parental PIN  </div>
				<div class="block" > <input type="password" required name="cb_pin__verify" id="cb_pin__verify" size="22"/> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>
			<div class="inline" > 	
				<div class="block"> How did you hear about us? </div>
				<div class="block" > <input type="text" required name="cb_marketingsource" id="cb_marketingsource" value="" size="25"  title="How did you hear about us? &nbsp;A friend's email? &nbsp;Link from another website you were on? &nbsp;Google search? &nbsp;Facebook? &nbsp;Just tell us what we're doing right to get the word out about how we can help protect your family!"> </div>
				<div class="block" style="position:absolute;color:rgb(255,20,20);">  </div>
			</div>		
			<div style="clear:both;"></div>


		</div>

		<div class="genBox">
		<span style="text-shadow: 1px 1px 5px white;"> Step 2: Choose a streaming plan</span>
		</div>

		<div class="genBox2">
			
			<div style="width:91%;margin:auto auto auto auto;">
				<a class="leftBox" id="option1">
					<h2 style="color:black;"> Send Me a ROKU</h2>
					<img src="/images/roku/rokuwithremote.png" border="0" style="width: 150px;  border: 0px;">
					<img src="/images/checkmark.png" style="opacity:0.0" id="checkOption1"/>
					<input type="radio" name="cbpplanE[0][selected][]" id="cbpplan33" value="33" mosreq="1" moslabel="" class="required" >
					<p style="text-align:left;">Want to watch MorningStar on your TV? Let us send you a preconfigured Roku with only the wholesome content you want.</p>
					<ul style="text-align:left;">
						<li><b>FIRST MONTH FREE,</b> then only <b>$8.99/month</b> after that</li>
						<li>Unlimited streaming</li>
						<li>More Christian movies and TV episodes that Netflix and Amazon Prime</li>
						<li>Watch movies on different devices, in multiple rooms, at the same time!</li>
						<li>Fully-refundable equipment deposit of $49.99 (up-front) </li>
						<li><b>High-Speed wireless internet required</b></li>
					</ul>
				</a>
				<a class="rightBox" id="option2">
				 <h2 style="color:black;">Unlimited Streaming</h2>
				 <img src="/images/MacBook.jpeg" border="0" style="width: 139px; border: 0px;">
				 <img src="/images/checkmark.png" style="opacity:0.0" id="checkOption2"/>
				 <input type="radio" name="cbpplanE[0][selected][]" id="cbpplan29" value="29" checked="checked" mosreq="1" moslabel="" class="required" cbsubschkdef="1" style="font-size:50px;">
				 <p style="text-align:left;">Want to watch MorningStar on your computer, Roku, Chromecast, smartphone or tablet? We've got you covered. Welcome to the best alternative to the traditional media outlets, helping you "guard your hearts" with top-notch Christian and faith-friendly movies and TV. </p>
				<ul style="text-align:left;">
					<li><b>FIRST MONTH FREE,</b> then only <b>$5.99/month</b> after that</li>
					<li>Unlimited streaming </li>
					<li>More Christian movies and TV episodes that Netflix and Amazon Prime</li>
					<li>Use your existing devices</li>
					<li><b>High-Speed internet required</b></li>
				</ul>
				</a>
				<div style="clear:both"></div>
			</div>	
			
		</div>
		<input type="submit"  value="Register" class="instantButton" style="margin-top:15px;margin:25px auto auto auto;">
		<input type="hidden" name="id" value="0" />
		<input type="hidden" name="gid" value="0" />
		<input type="hidden" name="emailpass" value="0" />
		<input type="hidden" name="option" value="com_comprofiler" />
		<input type="hidden" name="task" value="saveregisters" />
		<?
			echo cbGetSpoofInputTag( null, $cbSpoofString )."\n"; 
			echo cbGetRegAntiSpamInputTag( $regAntiSpamValues )."\n";
		?>
	</div>	
</form>
</div>

<script type="text/javascript">

jQuery( document ).ready(function() {
    
jQuery('#checkOption2').fadeTo(200, 1);

	jQuery( "#option1" ).click(function() {
	 
		jQuery('#checkOption1').fadeTo(200, 1);
		jQuery('#checkOption2').fadeTo(200, 0);
		jQuery('#cbpplan33').attr('checked',true);


	});

	jQuery( "#option2" ).click(function() {
	 
		jQuery('#checkOption2').fadeTo(200, 1);
		jQuery('#checkOption1').fadeTo(200, 0);
		jQuery('#cbpplan29').attr('checked',true);
	 
	});

	jQuery("#register").validate({

		errorPlacement: function(error, element) {
		  
		    error.appendTo( element.parent("div").next("div") );

		},

		onkeyup: false,
		rules: {

			password: "required",
			cb_marketingsource: "required",
			password__verify: {

				equalTo: "#password"

			},
			cb_pin__verify: {

				equalTo: "#cb_pin"

			},
			email: {

				remote: {

					url: "/check_email.php",
					type: "post",
					data: {

						email: function(){

							return jQuery('#email').val();

						}

					}

				}

			},
			username: {

				remote: {

					url: "/check_username.php",
					type: "post",
					data: {

						username: function(){

							return jQuery('#username').val();

						}						
						
					}

				}

			}

		}

	});

});

</script>