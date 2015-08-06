<?
function process_first_form($db,$user){

	$id = JRequest::getVar('(id)');
    $title = $db->quote(JRequest::getVar('title'));
    $year = $db->quote(JRequest::getVar('year'));
    $official_website_or_page = $db->quote(JRequest::getVar('official_website_or_page'));
    $stream_file_name = $db->quote(JRequest::getVar('stream_file_name'));
    $stream_key = $db->quote(JRequest::getVar('stream_key'));
    $is_tv = $db->quote(JRequest::getVar('is_tv'));
    $streaming_end_date = $db->quote(JRequest::getVar('streaming_end_date'));
    $streaming_start_date = $db->quote(JRequest::getVar('streaming_start_date'));
    $season = $db->quote(JRequest::getVar('season'));
    $shopping_website_or_page = $db->quote(JRequest::getVar('shopping_website_or_page'));
    $MStar_Approved = $db->quote(JRequest::getVar('MStar_Approved'));
    $Disapproval_Reason = $db->quote(JRequest::getVar('Disapproval_Reason'));
    $vendor1 = $db->quote(JRequest::getVar('vendor1'));

	if(id_unlocked($id,$db,$user)){

		lock_id($id,$db,$user);

	    if (JRequest::getVar('submitted') == 'submit-new') {

				$q = "	INSERT INTO source (id,title,official_website_or_page,stream_file_name, stream_key, is_tv, shopping_website_or_page, vendor1, MStar_Approved, Disapproval_Reason, season, ralph, streaming_end_date, streaming_start_date, year) VALUES 					
					({$id}, {$title}, {$official_website_or_page}, {$stream_file_name}, {$stream_key}, {$is_tv}, {$shopping_website_or_page}, {$vendor1}, {$MStar_Approved}, {$Disapproval_Reason}, {$season}, 0, {$streaming_end_date}, {$streaming_start_date}, {$year}) 			
				";

				$db->setQuery($q);
				$db->query();
			
	    } else /* if submitted = submit-update */ {

	        $vals = array(
	            "title" => $title,
	            "year"	=> $year,
	            "official_website_or_page" => $official_website_or_page,
	            "stream_file_name" => $stream_file_name,
	            "stream_key" => $stream_key,
	            "is_tv"		=> $is_tv,
	            "streaming_end_date"	=> $streaming_end_date,
	            "streaming_start_date"			=> $streaming_start_date,
	            "shopping_website_or_page" => $shopping_website_or_page,
	            "vendor1"			=> $vendor1,
	            "MStar_Approved" => $MStar_Approved,
	            "Disapproval_Reason" => $Disapproval_Reason,
	            "season"	=> $season

	        );
			
	        update_source($db,$vals,$id);

		}

	}else{

		$errors = array(
			"ERROR: Cannot create or update the movie with ID ".$id." as this movie is currently locked by another person. Did you run an ID check first?" 
		);
		return $errors;
	}	

}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function first_form($db){
	
	$green    = "rgb(150,255,150)";
	$blue     = "rgb(150,150,255)";
	$red 	  = "rgb(255,100,100)";	
	$height   = 100;

	$columns1 = array(
	    array("(id)",1,$green,'text',40),
	    array("title",1,$green,'text',150) /* initial mstar value*/,
	    array("year",1,$green,'text',150) /* initial mstar value*/,
	    array("official_website_or_page",0,$blue,'text',150),
	    array("stream_file_name",0,$blue,'text',150),
	    array("stream_key",0,$blue,'text',150),
	    array("is_tv",0,$blue,'text',150),
	    array("season",0,$blue,'text',150),
	    array("shopping_website_or_page",1,$green,'text',150),
	    array("MStar_Approved",1,$green,'text',35),
	    array("Disapproval_Reason",0,$blue,'text',150),
	    array("vendor1",0,$blue,'text',150)
	);

	$q = "
		SELECT MAX(id) FROM source 
	";
		
	$db->setQuery($q);

	$max_mstar_id = $db->loadResult();
	$numeric_max_mstar_id = str_replace("m", "", $max_mstar_id);
	$numeric_new_mstar_id = $numeric_max_mstar_id + 1;
	$new_mstar_id = "m" . $numeric_new_mstar_id;
	$new_mstar_id = $db->quote($new_mstar_id);

	?>
	<span>ID Check:</span><textarea id="id_check"></textarea><input value="check id" type="submit" id="id_check_button">
	<div class="item_wrapper">
		<form name="add_new" id="add_new" action="/index.php?option=com_content&view=article&id=93" method="post">
			<table class="add_item_table">
				<tr class="add_item_header">
	<?
					foreach ($columns1 as $column) {
	?>	
							<td style="background:<?php	echo $column[2]; ?>;">
	<?
								echo $column[0];
	?>
							</td>
	<?
					}
	?>	
				</tr>
				<tr class="add_item_fields">
	<?
					foreach ($columns1 as $column) {

						if ($column[0] == '(id)'){
	?>	
								<td style="background:<?php echo $column[2]; ?>;">
									<textarea id="id" name="<?php echo $column[0]; ?>" class="add_field" style="width:<?php echo $column[4]; ?>px; height:<?php echo $height; ?>px;"><?php echo $new_mstar_id; ?></textarea>
								</td>
	<?
						} elseif ($column[0] == 'MStar_Approved'){
	?>			
								<td style="background:<?php echo $column[2]; ?>;">									
									<select name="MStar_Approved" id="approved_checkbox">									
										<option value="yes">yes</option>										
										<option value="no">no</option>									
									</select>										
								</td>	
	<?

						} elseif ($column[0] == 'is_tv'){
	?>			
								<td style="background:<?php echo $column[2]; ?>;">									
									<select name="is_tv" id="is_tv_checkbox">									
										<option value="yes">yes</option>										
										<option value="no">no</option>									
									</select>										
								</td>	
	<?
						
						} elseif ($column[0] == 'season') {
	?>
							<td style="background:<?php echo $column[2]; ?>;">									
								<select name="season" id="season_checkbox">									
									<option value="1">1</option>										
									<option value="2">2</option>
									<option value="3">3</option>										
									<option value="4">4</option>
									<option value="5">5</option>										
									<option value="6">6</option>
									<option value="7">7</option>										
									<option value="8">8</option>
									<option value="9">9</option>										
									<option value="10">10</option>
									<option value="11">11</option>										
									<option value="12">12</option>
									<option value="13">13</option>										
									<option value="14">14</option>
									<option value="15">15</option>										
									<option value="16">16</option>
									<option value="17">17</option>										
									<option value="18">18</option>
									<option value="19">19</option>										
									<option value="20">20</option>									
								</select>										
							</td>
	<?
						} else{
	?>							
								<td style="background:<?php echo $column[2]; ?>;">								
									<textarea id="a<?php echo $column[0]; ?>" name="<?php echo $column[0]; ?>" class="add_field" style="width:<?php echo $column[4]; ?>px; height:<?php echo $height; ?>px;" ></textarea>							
								</td>		

	<?
						}

					}
	?>	
				</tr>
			</table> 
			<input class="submit_source" type="submit" name="submitted" value="submit-new" id="add"/>		<input class="submit_source" type="submit" name="submitted" value="submit-update" id="add-update"/>
		</form>
	</div>	
<?
}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function process_second_form($db,$user){

	// inputs from user form	
	$title = $db->quote(JRequest::getVar('title'));
    $synopsis = $db->quote(JRequest::getVar('synopsis'));
    $writer = $db->quote(JRequest::getVar('writer'));
    $producer = $db->quote(JRequest::getVar('producer'));
    $director = $db->quote(JRequest::getVar('director'));
    $actors = $db->quote(JRequest::getVar('actors'));
    (int) $runtime = JRequest::getVar('runtime');
    $rating = $db->quote(JRequest::getVar('rating (MPAA)'));
    $characters = $db->quote(JRequest::getVar('characters'));

    //hidden inputs
    $id = JRequest::getVar('(id)');
    $source = $db->quote(JRequest::getVar('source'));
    $genre = $db->quote(JRequest::getVar('genre'));
    $description = $db->quote(JRequest::getVar('description'));
    $approved = $db->quote(JRequest::getVar('approved'));
    $doves = $db->quote(JRequest::getVar('doves'));
    $age = $db->quote(JRequest::getVar('age'));
    $text = $db->quote(JRequest::getVar('text'));
    $rptdate = $db->quote(JRequest::getVar('rptdate'));
    $artwork = $db->quote(JRequest::getVar('artwork'));
    $reviewer = $db->quote(JRequest::getVar('reviewer'));
    $modified = $db->quote(JRequest::getVar('modified'));

	$vals = array(
        "title" 		=> $title,
        "synopsis"		=> $synopsis,
        "writer"		=> $writer,
        "producer"		=> $producer,
        "director"		=> $director,
        "actors"		=> $actors,
        "runtime"		=> $runtime,
        "rating"		=> $rating,
        "characters"	=> $characters,
        "source"		=> $source,
        "genre"			=> $genre,
        "description"	=> $description,
        "approved"		=> $approved,
        "doves"			=> $doves,
        "age"			=> $age,
        "text"			=> $text,
        "rptdate"		=> $rptdate,
        "artwork"		=> $artwork,
        "reviewer"		=> $reviewer,
        "modified"		=> $modified
    );
	
	if(id_unlocked($id,$db,$user)){
  		
  		update_source($db,$vals,$id);
	
	}else{

		$errors = array(
			"ERROR: Cannot update the movie with ID ".$id." as this movie is currently locked by another person. Did you run an ID check first?" 
		);
		return $errors;

	}

}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function second_form($db){

	$green    = "rgb(150,255,150)";
	$blue     = "rgb(150,150,255)";
	$red 	  = "rgb(255,100,100)";	
	$height   = 100;

	// get suggested Dove values for the 2nd form

	$id = JRequest::getVar('(id)'); 
	$xml_item = file_get_contents("http://www.dove.org/reviews/api/xml.aspx?id={$id}&key=ff4d7589c3");
	$movie = simplexml_load_string($xml_item);
    
	$title_cur = JRequest::getVar('title');

    //$title = $movie->review->title;
    $synopsis = $movie->review->synopsis;
    $writer = $movie->review->writer;
    $producer = $movie->review->producer;
    $director = $movie->review->director;
    $actors = $movie->review->actors;
    (int) $runtime = $movie->review->runtime;
    $rating = $movie->review->rating;
    $therelease = $movie->review->therelease;
    $vidrelease = $movie->review->vidrelease; 
    $distributor = $movie->review->distibutor; 	

    if ( /*!empty($therelease)*/ $therelease != "" ) {
	    $date = date_parse( $therelease ); 
	    $year = $date['year'];
	}else{
	    $date = date_parse( $vidrelease ); 
	    $year = $date['year'];
	}	

	if ( /*!empty($therelease)*/ $title == "" ) {
	    	
	    $q = "
	    	SELECT title FROM source WHERE id = {$id}
	    ";	

	    $db->setQuery($q);
	    $title = $db->loadResult;
	}

	$columns2 = array(
		array("title",1,$green,'text',150,"",$title_cur) /* initial Dove suggestion or carried over from 1*/,
	    array("synopsis",1,$green,'text',225, $synopsis),
	    array("writer",1,$blue,'text',75, $writer),
	    array("producer",0,$blue,'text',75, $producer),
	    array("director",0,$blue,'text',75, $director),
	    array("actors",1,$blue,'text',75, $actors),
	    array("runtime",1,$green,'text',60, $runtime),
	    array("rating (MPAA)",1,$blue,'text',80, $rating),
	    array("characters",1,$blue,'text',75), // used for tags!
	);

	// put these in hidden inputs
    $source = $movie->review->source;
    $genre = $movie->review->genre;
    $description = $movie->review->description;
    $approved = $movie->review->approved;
    $doves = $movie->review->doves;
    $age = $movie->review->age;
    $text = $movie->review->text;
    $rptdate = $movie->review->rptdate;
    $artwork = $movie->review->artwork;
    $reviewer = $movie->review->reviewer;
    $modified = $movie->review->modified;
	?>

	<div class="item_wrapper">				
		<form name="update_new5" id="update_new5" action="/index.php?option=com_content&view=article&id=93" method="post">					
			<table class="add_item_table">						
				<tr class="add_item_header"> 
				<?php
					foreach ($columns2 as $column) {
				?>										
						<td style="background:<?php	echo $column[2]; ?>;">										
				<?php
						if($column[0] != "title"){
							echo $column[0];
						}else{
							echo $column[0]." override"."<br><br>Current Title: ".$column[6];
						}	
				?>									
						</td>							
				<?php
					}
				?>							
				</tr>					
				<tr class="add_item_field">							
				<?php
					foreach ($columns2 as $column) {
				?>									
						<td style="background:<?php	echo $column[2]; ?>;">
							<textarea id="a<?php echo $column[0]; ?>" name="<?php echo $column[0]; ?>" class="add_field" style="width:<?php	echo $column[4]; ?>px; height:<?php	echo $height; ?>px;"
								<? if (strpos($id, 'm') === FALSE){ ?> readonly <? } ?>><? echo $column[5]; ?></textarea>									
						</td>							
				<?php
					}
				?>							
				</tr>					
			</table> 					
			<input class="submit_source" type="submit" name="submitted" value="submit" />					
			<input type="hidden" name="step" value="update_new" />					
			<input type="hidden" name="substep" value="0" />					
			<input type="hidden" name="(id)" value="<? echo $id; ?>" />		
			<input type="hidden" name="title_cur" value="<? echo $title_cur; ?>" />	
			<input type="hidden" name="source" value="<? echo $source; ?>" />
			<input type="hidden" name="genre" value="<? echo $genre; ?>" />
			<input type="hidden" name="description" value="<? echo $description; ?>" />
			<input type="hidden" name="approved" value="<? echo $approved; ?>" />
			<input type="hidden" name="doves" value="<? echo $doves; ?>" />
			<input type="hidden" name="age" value="<? echo $age; ?>" />
			<input type="hidden" name="text" value="<? echo $text; ?>" />
			<input type="hidden" name="rptdate" value="<? echo $rptdate; ?>" />
			<input type="hidden" name="artwork" value="<? echo $artwork; ?>" />
			<input type="hidden" name="reviewer" value="<? echo $reviewer; ?>" />
			<input type="hidden" name="modified" value="<? echo $modified; ?>" />		
		</form>			
	</div>		

<?
}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function process_third_form($db,$user){
		
	$id = JRequest::getVar('(id)');
    $title = $db->quote(JRequest::getVar('title'));
    $ptv_link = $db->quote(JRequest::getVar('ptv_link'));
    $kim_link = $db->quote(JRequest::getVar('kim_link'));
    $themes = $db->quote(JRequest::getVar('themes'));
    $category = $db->quote(JRequest::getVar('category'));
    $roku_category = $db->quote(JRequest::getVar('roku_category'));
    $extra_categories = $db->quote(JRequest::getVar('extra_categories'));
    $target_age = $db->quote(JRequest::getVar('target_age'));
    $official_publisher = $db->quote(JRequest::getVar('official_publisher'));
    $manufacturer = $db->quote(JRequest::getVar('manufacturer'));
    $additional_companies = $db->quote(JRequest::getVar('additional_companies'));
    $plugged_link = $db->quote(JRequest::getVar('plugged_link'));
   	$trailer = $db->quote(JRequest::getVar('trailer'));
   	$youtube = $db->quote(JRequest::getVar('youtube'));
   	$availability_date = $db->quote(JRequest::getVar('availability_date'));
    $vendor2 = $db->quote(JRequest::getVar('vendor2'));
 
 	$vals = array(
        "title" 				=> $title,
        "ptv_link"				=> $ptv_link,
        "kim_link"				=> $kim_link,
        "themes"				=> $themes,
        "category"				=> $category,
        "roku_category"			=> $roku_category,
        "extra_categories"		=> $extra_categories,
        "target_age"			=> $target_age,
        "official_publisher"	=> $official_publisher,
        "manufacturer"			=> $manufacturer,
        "additional_companies"	=> $additional_companies,
        "plugged_link"			=> $plugged_link,
        "trailer"				=> $trailer,
        "youtube"				=> $youtube,
        "availability_date"		=> $availability_date,
        "vendor2"				=> $vendor2
    );

	if(id_unlocked($id,$db,$user)){
  		
  		update_source($db,$vals,$id);
	
	}else{

		$errors = array(
			"ERROR: Cannot update the movie with ID ".$id." as this movie is currently locked by another person. Did you run an ID check first?" 
		);
		return $errors;

	}

}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------


function third_form($db){

	$green    = "rgb(150,255,150)";
	$blue     = "rgb(150,150,255)";
	$red 	  = "rgb(255,100,100)";	
	$height   = 100;

	$id = JRequest::getVar('(id)');
	$title_cur = JRequest::getVar('title');

	$roku_cat_list = array(
		"Christian Drama" 				=> "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/cdrama/",
		"7th Street Theater"			=> "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/TV/7th_street_theater/",
		"Genesis 7"						=> "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/TV/Genesis_7/",
		"American Heritage Collection"	=> "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/american_heritage_collection/",
		"Science"						=> "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/science/",
		"History"						=> "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/history/",
		"Mike's Inspiration Station"	=> "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/mikes_inspiration_station/",
		"Misc"							=> "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/misc/",
		"romance"						=> "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/romance/",
		"sci-fi"						=> "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/sci-fi/",
		"action"						=> "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/action/"
	);

	//get themes from DB    
	$q = "SELECT theme FROM themes";
	$db->setQuery($q);
	$themes = $db->loadColumn();

	//get movie categories, text
	$q = "SELECT name FROM xlefz_k2_categories WHERE published = 1 AND trash = 0";
	$db->setQuery($q);
	$cats = $db->loadColumn();

	//get movie categories, object array
	$q = "SELECT * FROM xlefz_k2_categories WHERE published = 1 AND trash = 0";
	$db->setQuery($q);
	$cats_obj_array = $db->loadObjectList();

	// define target ages
	$target_ages = array("Adults", "Teens/Adults", "All Ages", "Teens", "Kids");

	// get dove suggestions
	$xml_item = file_get_contents("http://www.dove.org/reviews/api/xml.aspx?id={$id}&key=ff4d7589c3");
	$movie = simplexml_load_string($xml_item);
	$pubman_sugg = $movie->distibutor;
	$tube_dv = $movie->youtube;

	// get all companies
	$q = "SELECT * FROM xlefz_virtuemart_manufacturers_en_gb";
	$db->setQuery($q);
	$companies = $db->loadObjectList();


	$columns3 = array(
		array("title",1,$green,'text',150,"", $title_cur) /* carried over from 2 */ ,
	    array("ptv_link",1,$blue,'text',75),
	    array("kim_link",1,$blue,'text',75),
	    array("themes",0,$blue,'text',75, $themes), // drop down, appended in common separated list to the textarea
	    array("category",1,$blue,'text',75, $cats_obj_array),
	    array("roku_category",1,$blue,'text',75, $roku_cat_list),
	    array("extra_categories",1,$blue,'text',75, $cats), // stacked drop downs dynamically generated from DB
	    array("target_age",1,$blue,'text',75, $target_ages) /* dropdown; use tooltips to explain difference between this and access level */,
	    array("official_publisher",1,$blue,'text',75, $companies, $pubman_sugg), // dropdown from DB; suggested value is Dove "distributor" that DOES NOT prepopulate tooltip says contact admins to add a company
	    // who we get streaming rights from/ who owns it
	    array("manufacturer",1,$blue,'text',75, $companies, $pubman_sugg), // dropdown from DB; suggested value is Dove "distributor" that DOES NOT prepopulate; tooltip says contact admins to add a company
	    // popular brand name 
	    array("additional_companies",1,$blue,'text',75, $companies), // appending dropdown plus text field
	    // companies we want to associate with the movie; need another DB field for this
	    array("plugged_link",1,$blue,'text',75), 
	    array("trailer",1,$blue,'text',75),
	    array("youtube",1,$blue,'text',75, $tube_dv), // this will be the short URL (generated if not inherited from Dove) from YouTube share, and will be parsed down to the ID
		array("availability_date",1,$blue,'text',75), // when the movie is available for rental
		array("vendor2",0,$blue,'text',150, $distributor)	// Dove suggestion doesn't prepopulate  
	);


	?>	
					
	<div class="item_wrapper">						
		<form name="update_new2" id="update_new2" action="/index.php?option=com_content&view=article&id=93" method="post">					
			<table class="add_item_table">								
				<tr class="add_item_header">									
				<?
					foreach ($columns3 as $column) {
				?>												
						<td style="background:<?php echo $column[2]; ?>;">												
				<?
							if($column[0] != "title"){
								echo $column[0];
							}else{
								echo $column[0]." override"."<br><br>Current Title: ".$column[6];
							}	
				?>											
						</td>									
				<?
					}
				?>									
				</tr>
				<tr class="add_item_fields">
				<?
					foreach ($columns3 as $column) {
							
						if( $column[0] == "themes" ){ ?>

							<td style="background:<?php echo $column[2]; ?>;">
								<select class="themes_option" id="<? echo $column[0]; ?>">
										<option></option>
									<? foreach ($column[5] as $key => $value) { ?>
										<option value="<? echo $value;?>">  
											<? echo $value; ?>	
										</option>
									<? } ?>
								</select><div id="undo_theme" class="undo">undo</div>											
								<textarea id="a2<?php echo $column[0]; ?>" name="<?php echo $column[0]; ?>" class="add_field" style="width:<?php echo $column[4]; ?>px; height:<?php echo $height; ?>px;" readonly></textarea>											
							</td>															
																							
						<? }elseif ($column[0] == "extra_categories") { ?>

							<td style="background:<?php echo $column[2]; ?>;">
								<select class="extra_cat_option" id="<? echo $column[0]; ?>">
										<option></option>
									<? foreach ($column[5] as $key => $value) { ?>
										<option value="<? echo $value;?>">  
											<? echo $value; ?>	
										</option>
									<? } ?>
								</select><div id="undo_cat" class="undo">undo</div>											
								<textarea id="a2<?php echo $column[0]; ?>" name="<?php echo $column[0]; ?>" class="add_field" style="width:<?php echo $column[4]; ?>px; height:<?php echo $height; ?>px;" readonly></textarea>											
							</td>
					
						<?	}elseif ($column[0] == "category"){ ?>

							<td style="background:<?php echo $column[2]; ?>;">
								<select name="<?php echo $column[0]; ?>">
										<option></option>
									<? foreach ($column[5] as $key => $row) { ?>
										<option value="<? echo $row->id; ?>">  
											<? echo $row->name; ?>	
										</option>
									<? } ?>
								</select>																				
							</td>

						<?	}elseif ($column[0] == "roku_category"){ ?>

							<td style="background:<?php echo $column[2]; ?>;">
								<select name="<?php echo $column[0]; ?>">
										<option></option>
									<? foreach ($column[5] as $key => $value) { ?>
										<option value="<? echo $value; ?>">  
											<? echo $key; ?>	
										</option>
									<? } ?>
								</select>																				
							</td>

						<?	}elseif ($column[0] == "target_age"){ ?>
							
							<td style="background:<?php echo $column[2]; ?>;">
								<select name="<?php echo $column[0]; ?>">
										<option></option>
									<? foreach ($column[5] as $key => $value) { ?>
										<option value="<? echo $value;?>">  
											<? echo $value; ?>	
										</option>
									<? } ?>
								</select>																				
							</td>

						<?	}elseif ($column[0] == "official_publisher"){ ?>
							
							<td style="background:<?php echo $column[2]; ?>;">
								<div> <? echo "Suggestion: ".$column[6]; ?> </div>
								<select name="<?php echo $column[0]; ?>">
										<option></option>
									<? foreach ($column[5] as $key => $row) { ?>
										<option value="<? echo $row->virtuemart_manufacturer_id; ?>">  
											<? echo $row->mf_name; ?>	
										</option>
									<? } ?>
								</select>																				
							</td>

						<?	}elseif ($column[0] == "manufacturer"){ ?>
							
							<td style="background:<?php echo $column[2]; ?>;">
								<div> <? echo "Suggestion: ".$column[6]; ?> </div>
								<select name="<?php echo $column[0]; ?>">
										<option></option>
									<? foreach ($column[5] as $key => $row) { ?>
										<option value="<? echo $row->virtuemart_manufacturer_id; ?>">  
											<? echo $row->mf_name; ?>	
										</option>
									<? } ?>
								</select>																				
							</td>	

						<? }elseif ($column[0] == "additional_companies") { ?>

							<td style="background:<?php echo $column[2]; ?>;">
								<select class="extra_comp_option" id="<? echo $column[0]; ?>">
										<option></option>
									<? foreach ($column[5] as $key => $row) { ?>
										<option value="<? echo $row->mf_name; ?>">  
											<? echo $row->mf_name; ?>	
										</option>
									<? } ?>
								</select><div id="undo_comp" class="undo">undo</div>											
								<textarea id="a2<?php echo $column[0]; ?>" name="<?php echo $column[0]; ?>" class="add_field" style="width:<?php echo $column[4]; ?>px; height:<?php echo $height; ?>px;" readonly></textarea>											
							</td>

						<? }elseif ($column[0] == "youtube") { ?>

							<td style="background:<?php echo $column[2]; ?>;">
								<div style="visibility: hidden;">
									<select >
										<option></option>
									</select><div class="undo">undo</div>	
								</div>	
								<textarea id="a<?php echo $column[0]; ?>" name="<?php echo $column[0]; ?>" class="add_field" style="width:<?php echo $column[4]; ?>px; height:<?php echo $height; ?>px;" 
								><? echo $column[5]; ?></textarea>											
							</td>				

						<? }else{ ?>									
							
							<td style="background:<?php echo $column[2]; ?>;">
								<div style="visibility: hidden;">
									<select>
										<option></option>
									</select><div class="undo">undo</div>	
								</div>	
								<textarea id="a<?php echo $column[0]; ?>" name="<?php echo $column[0]; ?>" class="add_field" style="width:<?php echo $column[4]; ?>px; height:<?php echo $height; ?>px;" ></textarea>											
							</td>	

					<?
						   }
   
					}

					?>									
				</tr>											
			</table> 							
		<input class="submit_source" type="submit" name="submitted" value="submit" />							
		<input type="hidden" name="step" value="update_new" />							
		<input type="hidden" name="substep" value="1" />							
		<input type="hidden" name="(id)" value="<? echo $id; ?>" />	
		<input type="hidden" name="title_cur" value="<? echo $title; ?>" />						
		</form>					
	</div>
<? 
}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function process_fourth_form($db,$user){
	
	// inputs from user form	
	$id = JRequest::getVar('(id)');
	$title = $db->quote(JRequest::getVar('title'));
    $access_level = $db->quote(JRequest::getVar('access_level'));
    $overall_rating =  $db->quote(JRequest::getVar('overall_rating'));
    $CLCbible = JRequest::getVar('CLCbible');
    $CLCsex = JRequest::getVar('CLCsex');
    $CLCviol = JRequest::getVar('CLCviol');
    $CLClan = JRequest::getVar('CLClan');
    $CLCdrug = JRequest::getVar('CLCdrug');
    $CLCother = JRequest::getVar('CLCother');
    $CLCcontr = JRequest::getVar('CLCcontr');

    //hidden inputs      

    	$CLCbible		= $CLCbible + 1;
        $CLCsex			= $CLCsex + 1;
        $CLCviol		= $CLCviol + 1;
        $CLClan			= $CLClan + 1;
        $CLCdrug		= $CLCdrug + 1;
        $CLCother		= $CLCother + 1;
        $CLCcontr		= $CLCcontr + 1;

	$vals = array(
        "title" 		=> $title,
        "access_level"	=> $access_level,
        "overall_rating"=> $overall_rating,	
        "CLCbible"		=> $CLCbible,
        "CLCsex"		=> $CLCsex,
        "CLCviol"		=> $CLCviol,
        "CLClan"		=> $CLClan,
        "CLCdrug"		=> $CLCdrug,
        "CLCother"		=> $CLCother,
        "CLCcontr"		=> $CLCcontr
    );
	
	if(id_unlocked($id,$db,$user)){
  		
  		update_source($db,$vals,$id);
  		unlock_id($id,$db);
	
	}else{

		$errors = array(
			"ERROR: Cannot update the movie with ID ".$id." as this movie is currently locked by another person. Did you run an ID check first?" 
		);
		return $errors;

	}

}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function fourth_form($db){

	$access_levels = array(
		"Toddlers SB"	=> 16,
		"Toddlers"		=> 8,
		"Kids SB"		=> 13,
		"Kids"			=> 8,
		"Teens SB"		=> 15,
		"Teens"			=> 7,
		"Adults SB"		=> 14,
		"Adults"		=> 6
	);

	$id = JRequest::getVar('(id)');
	$title_cur = JRequest::getVar('title');

	$green    = "rgb(150,255,150)";
	$blue     = "rgb(150,150,255)";
	$red 	  = "rgb(255,100,100)";	
	$height   = 100;

	$xml_item = file_get_contents("http://www.dove.org/reviews/api/xml.aspx?id={$id}&key=ff4d7589c3");
	$movie = simplexml_load_string($xml_item);
	    $age = $db->quote($movie->review->age);
	    $sex = $db->quote($movie->review->sex);
	    $language = $db->quote($movie->review->language);
	    $violence = $db->quote($movie->review->violence);
	    $drugs = $db->quote($movie->review->drugs);
	    $nudity = $db->quote($movie->review->nudity);
	    $occultism = $db->quote($movie->review->occultism);

	$columns4 = array(
	array("title",1,$green,'text',150,"",$title_cur) /* carried over from 3*/ ,
	array("access_level",0,$blue,'text',75, $access_levels),

	array("overall_rating",1,$green,'text',30),

	array("CLCbible",1,$red,'text',30, locked),
	array("CLCsex",1,$red,'text',30, locked),
	array("CLCviol",1,$red,'text',30, locked),
	array("CLClan",1,$red,'text',30, locked),
	array("CLCdrug",1,$red,'text',30, locked),
	array("CLCother",1,$red,'text',30, locked),
	array("CLCcontr",1,$red,'text',30, locked),

	array("M_Bible",1,$green,'text',30),
	array("M_Sex",1,$green,'text',30),
	array("M_Viol",1,$green,'text',30),
	array("M_Lan",1,$green,'text',30),
	array("M_Drug",1,$green,'text',30),
	array("M_Other",1,$green,'text',30),
	array("M_Contr",1,$green,'text',30),

	array("D_Sex",0,$blue,'text',10, locked, $sex),
	array("D_Viol",0,$blue,'text',10, locked, $violence),
	array("D_Lan",1,$blue,'text',10, locked, $language),
	array("D_Drug",1,$blue,'text',10, locked, $drugs),
	array("D_Other",1,$blue,'text',10, locked, $occultism),
	array("D_Nude",1,$blue,'text',10, locked, $nudity),

	array("K_Sex",0,$blue,'text',20),
	array("K_Viol",0,$blue,'text',20),
	array("K_Lan",1,$blue,'text',20)

	);	

	?>
		
	<div class="item_wrapper">				
		<form name="update_new3" id="update_new3" action="/index.php?option=com_content&view=article&id=93" method="post">				
			<table class="add_item_table">						
				<tr class="add_item_header">							
				<?
					foreach ($columns4 as $column) {
				?>										
						<td style="background:<?php echo $column[2]; ?>;">										
				<?
							if($column[0] != "title"){
								echo $column[0];
							}else{
								echo $column[0]." override"."<br><br>Current Title: ".$column[6];
							}	
				?>									
						</td>	
				<?
					}
				?>							
				</tr>					
				<tr class="add_item_fields">							
				<?
					foreach ($columns4 as $column) {			
												
					 	if ($column[0] == 'access_level'){ ?>	
							
							<td style="background:<?php echo $column[2]; ?>;">
								<select name="<?php echo $column[0]; ?>">
										<option></option>
									<? foreach ($column[5] as $key => $value) { ?>
										<option value="<? echo $value; ?>">  
											<? echo $key; ?>	
										</option>
									<? } ?>
								</select>																				
							</td>

						<? } else{ ?>	

							<td style="background:<?php echo $column[2]; ?>;">										
								<textarea id="a<?php echo $column[0]; ?>" name="<?php echo $column[0]; ?>" class="add_field" style="width:<?php echo $column[4]; ?>px; height:<?php echo $height; ?>px;"
								<? if ($column[5] == "locked"){ ?> readonly <? } ?>><? if ( !isset($column[6]) ^ empty($column[6]) ^ $column[6] == "''" ) { echo ""; }else { echo $column[6]; } ?></textarea>									
							</td>	

				<? 		   }							

					}
				
				?>							
				</tr>					
			</table> 					
		<input class="submit_source" type="submit" name="submitted" value="submit" />			
		<input type="hidden" name="step" value="update_new" />					
		<input type="hidden" name="substep" value="2" />					
		<input type="hidden" name="(id)" value="<?php echo $id; ?>" />
		<input type="hidden" name="title_cur" value="<? echo $title; ?>" />					
		</form>			
	</div>

<?

}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function upload_form($db){

$id = JRequest::getVar('(id)');

?>

	<button name="k2" id="export_to_k2" onclick="export_to_k2(<? echo $id;?>)">Export to K2</button>
	<button name="roku" id="export_to_roku" onclick="export_to_roku(<? echo $id;?>)">Export to Roku</button>

<?
}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function update_source($db,$vals,$id){
    
    $vals = array_filter($vals);
	
    foreach ($vals as $key => $value) {
        if (!empty($value) && $value != "''" && $value !="'NaN'") {
            $values[$key] = $value;
        }
    }
	
    $count = count($values);
    $i     = 1;
	
	$q     = "UPDATE source SET ";
	
    foreach ($values as $key => $value) {
        if ($i == $count) {
            $q = $q . $key . " = " . $value . " WHERE id = " . $id;
        }else {
            $q = $q . " " . $key . " = " . $value . ",";
        }
        $i++;
    }

    //echo $q."<hr><br><br>";
    //print_r($vals);
    $db->setQuery($q);
    $db->query();

}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function export_roku_item($movie,$id,$db){

	$base_url = JURI::base();

	$path = $movie->roku_category;

	jimport('joomla.filesystem.file');
	$clean_filename = JFile::makeSafe( $movie->title );
	$clean_filename_nospace = str_replace(" ", "%20", $clean_filename);
	$title_nospace = str_replace(" ", "%20", $movie->title);

	$fulltext = $movie->synopsis;
	$introtext = str_replace("<p>", "", $fulltext);
	$introtext = str_replace("</p>", "", $introtext);
	//$introtext = substr($introtext, 0, 250);

	if($movie->is_tv == "yes"){
		$content_type = "TV";
	}elseif($movie->is_tv == "no"){
		$content_type = "Movie";
	}

	if($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/cdrama/"){
		//christian drama
		$year = $movie->year;
		// old stream path $stream_path = "movies/{$clean_filename} ({$year})";
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/cdrama/validate/";
		$img_path = "/";
	}elseif($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/TV/7th_street_theater/"){
		//7th street theater
		$parameters = substr ( $movie->title , 0 , 8 );
		$season = substr( $parameters, 0, 3 );
		$episode = substr( $parameters, 4, 8 );

		$stream_path = "TV/7th_street_theater/{$season}/{$episode}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/TV/7th_street_theater/".$season."/validate/";
		$img_path = "/7th_street_theater/";

	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/TV/Genesis_7/") {
		//Genesis 7
		$parameters = substr ( $movie->title , 0 , 8 );
		$season = substr( $parameters, 0, 3 );
		$episode = substr( $parameters, 4, 8 );
		echo $season."<br>".$episode;
		$stream_path = "TV/genesis_7/{$season}/{$episode}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/TV/Genesis_7/".$season."/validate/";
		echo $xml_path;
		$img_path = "/Genesis_7/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/american_heritage_collection/") {
		//
		
		$stream_path = "edu/american_heritage_collection/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/american_heritage_collection/validate/";
		$img_path = "/american_heritage_collection/";
	}elseif($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/animated/"){
		//Action
		$year = $movie->year;
		
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/animated/validate/";
		$img_path = "/";
	}
elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/science/") {
		//
		
		$stream_path = "edu/science/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/science/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/documentaries/") {
		//
		
		$stream_path = "edu/science/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/documentaries/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/documentaries/") {
		//
		
		$stream_path = "edu/science/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/documentaries/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/history/") {
		//
		
		$stream_path = "edu/history/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/history/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/mikes_inspiration_station/") {
		//
		
		$stream_path = "edu/mikes_inspiration_station/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/mikes_inspiration_station/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/misc/") {
		//
		
		$stream_path = "misc/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/misc/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/sci-fi/") {
		//
		
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/sci-fi/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/romance/") {
		//
		
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/romance/validate/";
		$img_path = "/";
	}
	elseif($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/short/"){
		//
		$year = $movie->year;
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/short/validate/";
		$img_path = "/";
	}
	elseif($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/picks/"){
		//picks
		$year = $movie->year;
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/picks/";
		$img_path = "/";
	}
	elseif($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/trailers/"){
		//trailers
		$year = $movie->year;
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/trailers/";
		$img_path = "/";
	}	
	elseif($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/action/"){
		//
		$year = $movie->year;
		// old stream path $stream_path = "movies/{$clean_filename} ({$year})";
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/action/validate/";
		$img_path = "/";
	}

	$runtime = $movie->runtime * 60;

	$movie_xml =	
		"<item sdImg=\"http://mstarvid.com/images/_virtuemart_product{$img_path}{$clean_filename_nospace}sd.jpg\" hdImg=\"http://mstarvid.com/images/_virtuemart_product{$img_path}{$clean_filename_nospace}hd.jpg\">
			<title>{$movie->title}</title>
			<contentType>{$content_type}</contentType>
			<contentQuality>HD</contentQuality>
			<streamFormat>hls</streamFormat>
			<media>
				<streamQuality>HD</streamQuality>
				<streamBitrate>0</streamBitrate>
				<streamUrl>https://d3o44rpd4mon6c.cloudfront.net/{$stream_path}/playlist.m3u8</streamUrl>
			</media>
			<media>
				<streamQuality>SD</streamQuality>
				<streamBitrate>0</streamBitrate>
				<streamUrl>https://d3o44rpd4mon6c.cloudfront.net/{$stream_path}/playlist.m3u8</streamUrl>
			</media>	
			<synopsis>{$introtext}</synopsis>
			<runtime>{$runtime}</runtime>
			<director>{$movie->director}</director>
			<worldView></worldView>
			<contentRating></contentRating>
			<bible>{$movie->CLCbible}</bible>
			<sex>{$movie->CLCsex}</sex>
			<language>{$movie->CLClan}</language>
			<violence>{$movie->CLCviol}</violence>
			<controversy>{$movie->CLCcontr}</controversy>
			<other>{$movie->CLCother}</other>
			<drug>{$movie->CLCdrug}</drug>
			<accessLevel>{$movie->access_level}</accessLevel>
			<rating>{$movie->rating}</rating>
			<actors>{$movie->actors}</actors>
		</item>";	
		
		//echo "http://mstarvid.com/images/_virtuemart_product{$img_path}{$clean_filename}sd.jpg";

	if($content_type == "TV"){

		//if($movie->roku_exported == "yes"){

			//run update eventually 

		//}else{

			$q = "UPDATE source SET roku_exported = 'yes' WHERE id = {$id}";
			$db->setQuery($q);
			$db->query();
			$file = fopen($xml_path.$clean_filename.".xml","w");
			fwrite($file, $movie_xml);
			echo "<br><br>".$xml_path.$clean_filename.".xml";
		//}

	}elseif($content_type == "Movie"){

		//if($movie->roku_exported == "yes"){

			//run update eventually

		//}else{

			$q= "UPDATE source SET roku_exported = 'yes' WHERE id = {$id}";
			$db->setQuery($q);
			$db->query();
			$file = fopen($xml_path.$clean_filename.".xml","w");
			fwrite($file, $movie_xml);
			//echo $file."<br><br>";
			//echo $movie_xml;
		//}

	}	

}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function export_k2_item($movie, $id, $db, $user_id){

	jimport('joomla.filesystem.file');
	$clean_filename = JFile::makeSafe( $movie->title );

	if($movie->is_tv == "yes"){
		$content_type = "TV";
	}elseif($movie->is_tv == "no"){
		$content_type = "Movie";
	}

	$runtime = $movie->runtime;
	$fulltext = $movie->synopsis;
	$introtext = str_replace("<p>", "", $fulltext);
	$introtext = str_replace("</p>", "", $introtext);
	$introtext = substr($introtext, 0, 250);
	$introtext = "<p>".$introtext."</p>";
	
	if (strpos($movie->id,'m') !== false) {
   		 $mstar_id = $movie->id;
   		 if($movie->dove_id != '' && $movie->id != "" && !is_null($movie->id) ){
   		 	$dove_id = $movie->dove_id;
   		 }
	}else{
		$dove_id = $movie->id;
	}
		
	if($content_type == "TV"){

		if($movie->k2_exported == "yes"){

			//run update eventually 

		}else{

			$k2movie = new stdClass();
			$k2movie->title = $movie->title;
			$k2movie->catid = $movie->category;
			$k2movie->published = 0;
			$k2movie->introtext = $introtext;
			$k2movie->fulltext = "<p>".$fulltext."</p>";
			$k2movie->video = $movie->youtube;
			$k2movie->created = date("Y-m-d H:i:s");  
			$k2movie->created_by = $user_id;
			$k2movie->trash = 0;
			$k2movie->access = $movie->access_level;
			$k2movie->featured = 0;
			$k2movie->language = "*";
			$result = JFactory::getDbo()->insertObject('xlefz_k2_items', $k2movie);		

			//update extra fields

			$q="SELECT MAX(id) FROM xlefz_k2_items
			";
			$db->setQuery($q);
			$max_id = $db->loadResult();
			$new_k2_id = $max_id;

			$extra_fields_array = array(
				"7" => 0,
				"9" => $movie->manufacturer,
				"11" => $movie->availability_date,
				"14" => 3,
				"15" => $movie->ptv_link,
				"16" => $movie->kim_link,
				"18" => $movie->rating,
				"19" => $movie->overall_rating,
				"20" => $movie->CLCviol,
				"21" => $movie->CLCsex,
				"22" => $movie->CLClan,
				"23" => $movie->CLCcontr,
				"24" => $movie->CLCdrug,
				"28" => $movie->CLCother,
				"30" => $movie->actors,
				"31" => $movie->director,
				"32" => $movie->producer,
				"33" => $movie->writer,
				"34" => $movie->runtime,
				"35" => $movie->official_website_or_page,
				"36" => $movie->themes,
				"37" => $movie->CLCbible,
				"38" => $movie->characters,
				"41" => $movie->vendor1,
				"43" => $movie->year,
				"44" => $movie->official_publisher,
				"45" => $dove_id,
				"54" => $mstar_id,
				"47" => $movie->category,
				"49" => $movie->title,
				"50" => $movie->plugged_link,
				"53" => $movie->extra_categories,
				"52" => $movie->stream_key,
				"55" => $movie->is_tv
			);

			//$extra_fields_blank = "[{\"id\":\"55\",\"value\":\"0\"},{\"id\":\"7\",\"value\":\"0\"},{\"id\":\"9\",\"value\":\"0\"},{\"id\":\"11\",\"value\":\"0\"},{\"id\":\"14\",\"value\":\"0\"},{\"id\":\"15\",\"value\":\"0\"},{\"id\":\"16\",\"value\":\"0\"},{\"id\":\"18\",\"value\":\"0\"},{\"id\":\"19\",\"value\":\"0\"},{\"id\":\"20\",\"value\":\"0\"},{\"id\":\"21\",\"value\":\"0\"},{\"id\":\"22\",\"value\":\"0\"},{\"id\":\"23\",\"value\":\"0\"},{\"id\":\"24\",\"value\":\"0\"},{\"id\":\"28\",\"value\":\"0\"},{\"id\":\"30\",\"value\":\"0\"},{\"id\":\"31\",\"value\":\"0\"},{\"id\":\"32\",\"value\":\"0\"},{\"id\":\"33\",\"value\":\"0\"},{\"id\":\"34\",\"value\":\"0\"},{\"id\":\"35\",\"value\":\"0\"},{\"id\":\"36\",\"value\":\"0\"},{\"id\":\"37\",\"value\":\"0\"},{\"id\":\"38\",\"value\":\"0\"},{\"id\":\"41\",\"value\":\"0\"},{\"id\":\"43\",\"value\":\"0\"},{\"id\":\"44\",\"value\":\"0\"},{\"id\":\"45\",\"value\":\"0\"},{\"id\":\"52\",\"value\":\"0\"},{\"id\":\"47\",\"value\":\"0\"},{\"id\":\"49\",\"value\":\"0\"},{\"id\":\"50\",\"value\":\"0\"},{\"id\":\"53\",\"value\":\"0\"},{\"id\":\"52\",\"value\":\"0\"}]";

			//$q="update xlefz_k2_items set extra_fields = '{$extra_fields_blank}' where id='{$new_k2_id}'";
			//$db->setQuery($q);
			//$result = $db->query();
			foreach($extra_fields_array as $key => $value){
				
				set_extra_field($new_k2_id,$key,$value);

			}	
			//add k2 id to source
			$q= "
				update source set k2ID = {$new_k2_id} where id='{$movie->id}'
			";
			$db->setQuery($q);
			$db->query();

		}

	}elseif($content_type == "Movie"){

		if($movie->k2_exported == "yes"){

			//run update eventually

		}else{

			$k2movie = new stdClass();
			$k2movie->title = $movie->title;
			$k2movie->catid = $movie->category;
			$k2movie->published = 0;
			$k2movie->introtext = $introtext;
			$k2movie->fulltext = "<p>".$fulltext."</p>";
			$k2movie->video = $movie->youtube;
			$k2movie->created = date("Y-m-d H:i:s");  
			$k2movie->created_by = $user_id;
			$k2movie->trash = 0;
			$k2movie->access = $movie->access_level;
			$k2movie->featured = 0;
			$k2movie->language = "*";
			$result = JFactory::getDbo()->insertObject('xlefz_k2_items', $k2movie);		

			//update extra fields

			$q="SELECT MAX(id) FROM xlefz_k2_items
			";
			$db->setQuery($q);
			$max_id = $db->loadResult();
			$new_k2_id = $max_id;

			$extra_fields_array = array(
				"7" => 0,
				"9" => $movie->manufacturer,
				"11" => $movie->availability_date,
				"14" => 3,
				"15" => $movie->ptv_link,
				"16" => $movie->kim_link,
				"18" => $movie->rating,
				"19" => $movie->overall_rating,
				"20" => $movie->CLCviol,
				"21" => $movie->CLCsex,
				"22" => $movie->CLClan,
				"23" => $movie->CLCcontr,
				"24" => $movie->CLCdrug,
				"28" => $movie->CLCother,
				"30" => $movie->actors,
				"31" => $movie->director,
				"32" => $movie->producer,
				"33" => $movie->writer,
				"34" => $movie->runtime,
				"35" => $movie->official_website_or_page,
				"36" => $movie->themes,
				"37" => $movie->CLCbible,
				"38" => $movie->characters,
				"41" => $movie->vendor1,
				"43" => $movie->year,
				"44" => $movie->official_publisher,
				"45" => $dove_id,
				"54" => $mstar_id,
				"47" => $movie->category,
				"49" => $movie->title,
				"50" => $movie->plugged_link,
				"53" => $movie->extra_categories,
				"52" => $movie->stream_key,
				"55" => $movie->is_tv	
			);

			//foreach ($extra_fields_array as $key => $value)	{
			//	echo $key.":".$value;
			//}

			//$extra_fields_blank = "[{\"id\":\"55\",\"value\":\"0\"},{\"id\":\"7\",\"value\":\"0\"},{\"id\":\"9\",\"value\":\"0\"},{\"id\":\"11\",\"value\":\"0\"},{\"id\":\"14\",\"value\":\"0\"},{\"id\":\"15\",\"value\":\"0\"},{\"id\":\"16\",\"value\":\"0\"},{\"id\":\"18\",\"value\":\"0\"},{\"id\":\"19\",\"value\":\"0\"},{\"id\":\"20\",\"value\":\"0\"},{\"id\":\"21\",\"value\":\"0\"},{\"id\":\"22\",\"value\":\"0\"},{\"id\":\"23\",\"value\":\"0\"},{\"id\":\"24\",\"value\":\"0\"},{\"id\":\"28\",\"value\":\"0\"},{\"id\":\"30\",\"value\":\"0\"},{\"id\":\"31\",\"value\":\"0\"},{\"id\":\"32\",\"value\":\"0\"},{\"id\":\"33\",\"value\":\"0\"},{\"id\":\"34\",\"value\":\"0\"},{\"id\":\"35\",\"value\":\"0\"},{\"id\":\"36\",\"value\":\"0\"},{\"id\":\"37\",\"value\":\"0\"},{\"id\":\"38\",\"value\":\"0\"},{\"id\":\"41\",\"value\":\"0\"},{\"id\":\"43\",\"value\":\"0\"},{\"id\":\"44\",\"value\":\"0\"},{\"id\":\"45\",\"value\":\"0\"},{\"id\":\"52\",\"value\":\"0\"},{\"id\":\"47\",\"value\":\"0\"},{\"id\":\"49\",\"value\":\"0\"},{\"id\":\"50\",\"value\":\"0\"},{\"id\":\"53\",\"value\":\"0\"},{\"id\":\"52\",\"value\":\"0\"}]";

			//$q="update xlefz_k2_items set extra_fields = '{$extra_fields_blank}' where id='{$new_k2_id}'";
			//$db->setQuery($q);
			//$result = $db->query();
			foreach($extra_fields_array as $key => $value){
				
				set_extra_field($new_k2_id,$key,$value);

			}	
			//add k2 id to source
			$q= "
				update source set k2ID = {$new_k2_id} where id='{$movie->id}'
			";
			$db->setQuery($q);
			$db->query();

		}

	}	

}



// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function id_unlocked($id,$db,$user){

	$q = "
		SELECT COUNT(*) FROM source WHERE id = {$id} AND locked = 1 AND locked_by != {$user->id}
	";
	$db->setQuery($q);
	$result = $db->loadResult();

	if($result > 0){

		return FALSE;

	}else{

		return TRUE;

	}

}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function lock_id($id,$db,$user){

	$q= "
		UPDATE source SET locked = 1, locked_by = {$user->id} WHERE id = {$id}
	";
	$db->setQuery($q);
	$db->query();

}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function unlock_id($id,$db){

	$q= "
		UPDATE source SET locked = 0 WHERE id = {$id}
	";
	$db->setQuery($q);
	$db->query();

}

// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function print_errors($errors){
?>
	
	<p style="color: rgb(255,0,0); font-size: 18pt">
		The following errors were found:		
	</p>
 
<?
	foreach($errors as $key => $value){
?>

		<p style="color: rgb(255,0,0); font-size: 12pt">
			<? echo "E({$key}): ".$value; ?>
		</p>

<?
	}

}


// ------------------------------------------------------------------------------------
// ************************************************************************************
// ------------------------------------------------------------------------------------

function get_movie_object($id){

	$db = JFactory::getDBO();
	$q = "SELECT * FROM source WHERE k2ID='{$id}' limit 1";
	$db->setQuery($q);
	$movie = $db->loadObject();

	$base_url = JURI::base();

	$path = $movie->roku_category;

	$query = $db->getQuery(true);
	$query->select('name');
	$query->from($db->quoteName('xlefz_k2_categories'));
	$query->join('INNER',$db->quoteName('xlefz_k2_items') . ' ON (' . $db->quoteName('xlefz_k2_items.catid') . ' = ' . $db->quoteName('xlefz_k2_categories.id') . ')' );
	$query->where($db->quoteName('xlefz_k2_items.id')." = ".$db->quote($id));
 
	// Reset the query using our newly populated query object.
	$db->setQuery($query);
	$category = $db->loadResult();

	jimport('joomla.filesystem.file');
	$clean_filename = JFile::makeSafe( $movie->title );
	$clean_filename_nospace = str_replace(" ", "%20", $clean_filename);
	$title_nospace = str_replace(" ", "%20", $movie->title);

	$fulltext = $movie->synopsis;
	$introtext = str_replace("<p>", "", $fulltext);
	$introtext = str_replace("</p>", "", $introtext);
	//$introtext = substr($introtext, 0, 250);

	if($movie->is_tv == "yes"){
		$content_type = "TV";
	}elseif($movie->is_tv == "no"){
		$content_type = "Movie";
	}

	if($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/cdrama/"){
		//christian drama
		$year = $movie->year;
		// old stream path $stream_path = "movies/{$clean_filename} ({$year})";
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/cdrama/validate/";
		$img_path = "/";
	}elseif($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/TV/7th_street_theater/"){
		//7th street theater
		$parameters = substr ( $movie->title , 0 , 8 );
		$season = substr( $parameters, 0, 3 );
		$episode = substr( $parameters, 4, 8 );

		$stream_path = "TV/7th_street_theater/{$season}/{$episode}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/TV/7th_street_theater/".$season."/validate/";
		$img_path = "/7th_street_theater/";

	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/TV/Genesis_7/") {
		//Genesis 7
		$parameters = substr ( $movie->title , 0 , 8 );
		$season = substr( $parameters, 0, 3 );
		$episode = substr( $parameters, 4, 8 );
		echo $season."<br>".$episode;
		$stream_path = "TV/genesis_7/{$season}/{$episode}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/TV/Genesis_7/".$season."/validate/";
		echo $xml_path;
		$img_path = "/Genesis_7/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/american_heritage_collection/") {
		//
		
		$stream_path = "edu/american_heritage_collection/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/american_heritage_collection/validate/";
		$img_path = "/american_heritage_collection/";
	}elseif($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/animated/"){
		//Action
		$year = $movie->year;
		
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/animated/validate/";
		$img_path = "/";
	}
	elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/science/") {
		//
		
		$stream_path = "edu/science/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/science/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/documentaries/") {
		//
		
		$stream_path = "edu/science/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/documentaries/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/documentaries/") {
		//
		
		$stream_path = "edu/science/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/documentaries/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/history/") {
		//
		
		$stream_path = "edu/history/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/history/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/mikes_inspiration_station/") {
		//
		
		$stream_path = "edu/mikes_inspiration_station/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/edu/mikes_inspiration_station/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/misc/") {
		//
		
		$stream_path = "misc/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/misc/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/sci-fi/") {
		//
		
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/sci-fi/validate/";
		$img_path = "/";
	}elseif ($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/romance/") {
		//
		
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/romance/validate/";
		$img_path = "/";
	}elseif($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/short/"){
		//
		$year = $movie->year;
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/short/validate/";
		$img_path = "/";
	}elseif($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/picks/"){
		//picks
		$year = $movie->year;
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/picks/";
		$img_path = "/";
	}elseif($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/trailers/"){
		//trailers
		$year = $movie->year;
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/trailers/";
		$img_path = "/";
	}elseif($movie->roku_category == "/roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/action/"){
		//
		$year = $movie->year;
		// old stream path $stream_path = "movies/{$clean_filename} ({$year})";
		$stream_path = "movies/{$title_nospace}";
		$xml_path = "roku_Kqx4sQxJ9RHzKXq7x68wSYEA/xml/categories/action/validate/";
		$img_path = "/";
	}

	$runtime = $movie->runtime * 60;

	$category = 0;

	$moovie = new stdClass();
	$moovie->runtime = $runtime;
	$moovie->card_img = "http://mstarvid.com/images/_virtuemart_product{$img_path}{$clean_filename_nospace}hd.jpg"; 
	$moovie->description = $introtext;
	$moovie->category = $category;
	$moovie->stream_url = "https://d3o44rpd4mon6c.cloudfront.net/{$stream_path}/playlist.m3u8";  

	return $moovie;

}

?>

