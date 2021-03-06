<!DOCTYPE html>
<?php 
	
	$user = "NOT_CONNECTED";

	$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';

	$cs = Yii::app()->getClientScript();

	$CO2DomainName = isset(Yii::app()->params["CO2DomainName"]) ? Yii::app()->params["CO2DomainName"] : "CO2";

	$networkJson = Network::getNetworkJson(Yii::app()->params['networkParams']);

	$params = CO2::getThemeParams();
    $metaTitle = @$params["metaTitle"];
    $metaDesc = @$params["metaDesc"]; 
    $metaImg = Yii::app()->getRequest()->getBaseUrl(true)."/themes/CO2".@$params["metaImg"];

?>	
<html lang="en" class="no-js">
	
	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="title" content="<?php echo $metaTitle; ?>">
		<meta name="description" content="<?php echo $metaDesc; ?>">
		<meta name="author" content="pixelhumain">

		<meta property="og:image" content="<?php echo $metaImg; ?>"/>
		<meta property="og:description" content="<?php echo $metaDesc; ?>"/>
		<meta property="og:title" content="<?php echo $metaTitle; ?>"/>

		<title><?php echo $CO2DomainName; ?></title>

		<link rel='shortcut icon' type='image/x-icon' href="<?php echo (isset( $this->module->assetsUrl ) ) ? $this->module->assetsUrl : ""?>/images/favicon.ico" />

		<?php if( Yii::app()->params["forceMapboxActive"]==true &&  Yii::app()->params["mapboxActive"]==true ){ ?>
			<script src='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.js'></script>
			<link href='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.css' rel='stylesheet' />

			<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
			<link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css"> 

			<script src='//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js'></script>
			<link href='//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css' rel='stylesheet' />

		<?php }

			$cs->registerScriptFile(Yii::app() -> createUrl($this->module->id."/default/view/page/trad/dir/..|translation/layout/empty"));
		?>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- <style type="text/css">
			.form-group label.error{ color:red; font-size:10px; }
		</style> -->
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<!-- <body id="page-top" class="index" style="display: none;"> -->
	<body class="">
		 <!-- **************************************
        MAP CONTAINER
        ******************************************* -->
        <progress class="progressTop" max="100" value="20"></progress>
		<div id="mainMap">
			<?php $this->renderPartial($layoutPath.'mainMap'); ?>
		</div>

	<?php
		$this->renderPartial( $layoutPath.'modals' );
	?>
	
	<!-- **************************************
	MAP CONTAINER
	******************************************* -->
	<div id="mainMap">
		<?php $this->renderPartial($layoutPath.'mainMap'); ?>
	</div>

	<?php //get all my link to put in floopDrawer
		if(isset(Yii::app()->session['userId'])){
	      $myContacts = Person::getPersonLinksByPersonId(Yii::app()->session['userId']);
	      $myFormContact = $myContacts; 
	      $getType = (isset($_GET["type"]) && $_GET["type"] != "citoyens") ? $_GET["type"] : "citoyens";
	    }else{
	      $myFormContact = null;

	    }

	   // error_log("load IndexDefault");
	?>
	<!-- **************************************
	MENUS TOP AND LEFT CONTAINER
	******************************************* -->
	<?php $this->renderPartial($layoutPath.'menu.simply_short_info_profil', array("params" => $networkJson)); ?>
	<?php $this->renderPartial($layoutPath."menu.simplyMenuLeft", array("params" => $networkJson)); ?>
		<div class="col-md-12 col-sm-12 col-xs-12 my-main-container no-padding" style="top: 50px">
			<div class="col-md-10 col-md-offset-2 col-sm-9 col-sm-offset-3 col-xs-12 main-col-search no-padding" style="min-height: 490px; opacity: 1;">
			<?php $this->renderPartial("../network/simplyDirectory",array("params" => $networkJson)); ?>
			</div>
		</div>
	
	
		<?php //if(!isset(Yii::app()->session['userId']))
		$this->renderPartial($layoutPath."simply_login_register", array("params" => $networkJson));
		?>

	<!-- **************************************
		NOTIFICATION PANELS
		******************************************* -->
	<?php  
		//if(isset(Yii::app()->session['userId'])) 
			//$this->renderPartial($layoutPath.'notifications2');
		
		/* *****************************************
		Active Content from the controller
		******************************************* */

		/* *************************************
		END structure 
		*******************************************/

	?>
	<?php $this->renderPartial($layoutPath.'menu.menuBottom', array("params" => $networkJson)); ?>
	<?php $this->renderPartial($layoutPath."menu.menuSmall", array("params" => $networkJson)); ?>

		<!-- start: MAIN JAVASCRIPTS -->
		
		<?php
		echo "<!-- start: MAIN JAVASCRIPTS -->";
		echo "<!--[if lt IE 9]>";
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/plugins/respond.min.js' , CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl. '/plugins/excanvas.min.js' , CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl. '/plugins/jQuery/jquery-1.11.1.min.js' , CClientScript::POS_HEAD);
		echo "<![endif]-->";
		echo "<!--[if gte IE 9]><!-->";
		$cs->registerScriptFile(Yii::app()->request->baseUrl. '/plugins/jQuery/jquery-2.1.1.min.js' , CClientScript::POS_HEAD);
		echo "<!--<![endif]-->";

		//plugins shared by all themes
		$cssAnsScriptFilesModule = array(
			'/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js',
			'/plugins/bootstrap/js/bootstrap.min.js' , 
			'/plugins/bootstrap/css/bootstrap.min.css',
			'/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js' , 
			'/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css',
			'/plugins/velocity/jquery.velocity.min.js',
			'/plugins/ladda-bootstrap/dist/spin.min.js' , 
			'/plugins/ladda-bootstrap/dist/ladda.min.js' , 
			'/plugins/ladda-bootstrap/dist/ladda.min.css',
			'/plugins/ladda-bootstrap/dist/ladda-themeless.min.css',
			'/plugins/iCheck/jquery.icheck.min.js' , 
			'/plugins/iCheck/skins/all.css',
			'/plugins/jquery.transit/jquery.transit.js' , 
			'/plugins/TouchSwipe/jquery.touchSwipe.min.js' , 
			'/plugins/bootbox/bootbox.min.js' , 
			'/plugins/jquery-mockjax/jquery.mockjax.js' , 
			'/plugins/blockUI/jquery.blockUI.js' , 
			// '/plugins/toastr/toastr.js' , 
			// '/plugins/toastr/toastr.min.css',
			'/plugins/jquery-cookie/jquery.cookie.js' , 
			'/plugins/jquery-cookieDirective/jquery.cookiesdirective.js' , 
			'/plugins/jQuery-contextMenu/dist/jquery.contextMenu.min.js' , 
			'/plugins/jQuery-contextMenu/dist/jquery.contextMenu.min.css' , 
			'/plugins/jQuery-contextMenu/dist/jquery.ui.position.min.js' , 
			'/plugins/select2/select2.min.js' , 
			'/plugins/select2/select2.css',
			'/plugins/moment/min/moment.min.js' ,
			'/plugins/jquery-validation/dist/jquery.validate.min.js',
			'/plugins/jquery-validation/localization/messages_fr.js',
			'/plugins/lightbox2/css/lightbox.css',
			'/plugins/lightbox2/js/lightbox.min.js',
			'/plugins/animate.css/animate.min.css',
			'/plugins/font-awesome/css/font-awesome.min.css',
			'/plugins/font-awesome-custom/css/font-awesome.css',
			'/plugins/jquery.dynForm.js',
			'/js/api.js'
		);
		HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getRequest()->getBaseUrl(true));
		HtmlHelper::registerCssAndScriptsFiles( array('/js/default/formInMap.js') , $this->module->assetsUrl);

		$cssAnsScriptFilesModule = array(
			'/assets/js/cookie.js' ,

			'/assets/css/CO2/CO2-boot.css',
			'/assets/css/CO2/CO2-color.css',
			//'/assets/css/CO2/CO2.css',

			'/assets/css/styles.css',
			'/assets/css/styles-responsive.css',
			'/assets/css/plugins.css',
			'/assets/css/search.css',
			'/assets/css/search_simply.css',
			//'/assets/css/themes/theme-simple.css',
			'/assets/css/default/directory.css',
			'/assets/css/floopDrawerRight.css',
			'/assets/css/sig/sig.css',
			'/assets/css/freelancer.css',
			'/assets/css/news/index.css',	
		);
		HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);
		$this->renderPartial($layoutPath.'initJs', 
                                 array( "me"=>@$me, "myFormContact" => @$myFormContact));

        $this->renderPartial($layoutPath.'modals.'.$CO2DomainName.'.invite');
		//<!-- end: MAIN JAVASCRIPTS -->
		//<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		?>
		<script type="text/javascript">
		console.log("MainSearch2");
		var networkParams = "<?php echo Yii::app()->params['networkParams'] ?>";
		var networkJson = <?php echo json_encode($networkJson)?>;
		var globalTheme = "network";
		var mapIconTop = {
		    "default" : "fa-arrow-circle-right",
		    "citoyen":"<?php echo Person::ICON ?>", 
		    "person":"<?php echo Person::ICON ?>", 
		    "NGO":"<?php echo Organization::ICON ?>",
		    "LocalBusiness" :"<?php echo Organization::ICON_BIZ ?>",
		    "Group" : "<?php echo Organization::ICON_GROUP ?>",
		    "group" : "<?php echo Organization::ICON ?>",
		    "association" : "<?php echo Organization::ICON ?>",
		    "organization" : "<?php echo Organization::ICON ?>",
		    "organizations" : "<?php echo Organization::ICON ?>",
		    "GovernmentOrganization" : "<?php echo Organization::ICON_GOV ?>",
		    "event":"<?php echo Event::ICON ?>",
		    "events":"<?php echo Event::ICON ?>",
		    "project":"<?php echo Project::ICON ?>",
		    "projects":"<?php echo Project::ICON ?>",
		    "city": "<?php echo City::ICON ?>",
		    "entry": "fa-gavel",
		    "action": "fa-cogs",
		    "actions": "fa-cogs",
		    "poi": "fa-info-circle",
		    "video": "fa-video-camera"
		  };
		var mapColorIconTop = {
		    "default" : "dark",
		    "citoyen":"yellow", 
		    "person":"yellow", 
		    "NGO":"green",
		    "LocalBusiness" :"green",
		    "Group" : "green",
		    "group" : "green",
		    "association" : "green",
		    "organization" : "green",
		    "organizations" : "green",
		    "GovernmentOrganization" : "green",
		    "event":"orange",
		    "events":"orange",
		    "project":"purple",
		    "projects":"purple",
		    "city": "red",
		    "entry": "azure",
		    "action": "lightblue2",
		    "actions": "lightblue2",
		    "poi": "dark",
		    "video":"dark"
		  };

		var typesLabels = {
		  "<?php echo Organization::COLLECTION ?>":"Organization",
		  "<?php echo Event::COLLECTION ?>":"Event",
		  "<?php echo Project::COLLECTION ?>":"Project",
		};


		/* variables globales communexion */
		var inseeCommunexion = "<?php echo $inseeCommunexion; ?>";
		var cpCommunexion = "<?php echo $cpCommunexion; ?>";
		var cityNameCommunexion = "<?php echo $cityNameCommunexion; ?>";
		var regionNameCommunexion = "<?php echo $regionNameCommunexion; ?>";
		var countryCommunexion = "<?php echo $countryCommunexion; ?>";
		<?php if(@$nbCpByInsee && $nbCpByInsee > 1){ ?>
			nbCpbyInseeCommunexion = "<?php echo $nbCpByInsee; ?>";
			cityInseeCommunexion = "<?php echo $cityInsee; ?>";
		<?php } ?>
		var latCommunexion = 0;
		var lngCommunexion = 0;

		/* variables globales communexion */	
		var myContacts = <?php echo ($myFormContact != null) ? json_encode($myFormContact) : "null"; ?>;
		var myContactsById =<?php echo ($myFormContact != null) ? json_encode($myFormContact) : "null"; ?>;
		var userConnected = <?php echo isset($me) ? json_encode($me) : "null"; ?>;

		var proverbs = <?php echo json_encode(random_pic()) ?>;  

		var hideScrollTop = true;
		var lastUrl = null;
		var isMapEnd = <?php echo (isset( $_GET["map"])) ? "true" : "false" ?>;

		//used in communecter.js dynforms
		var tagsList = <?php echo json_encode(Tags::getActiveTags()) ?>;
		var eventTypes = <?php asort(Event::$types); echo json_encode(Event::$types) ?>;
		var organizationTypes = <?php echo json_encode( Organization::$types ) ?>;
		var avancementProject = <?php echo json_encode( Project::$avancement ) ?>;
		//var currentUser = <?php echo isset($me) ? json_encode(Yii::app()->session["user"]) : null?>;
		var rawOrganizerList = <?php echo json_encode(Authorisation::listUserOrganizationAdmin(Yii::app() ->session["userId"])) ?>;
		var organizerList = {};
		var poiTypes = <?php echo json_encode( Poi::$types ) ?>;
		var allReadyLoad=false;

		var urlTypes = <?php asort(Element::$urlTypes); echo json_encode(Element::$urlTypes) ?>;
		var classifiedTypes = <?php echo json_encode( Classified::$classifiedTypes ) ?>;
		var classifiedSubTypes = <?php echo json_encode( Classified::$classifiedSubTypes ) ?>;
		
		// GET LIST OF NETWORK'S TAGS
		if(networkJson != null && typeof networkJson.filter != "undefined" && typeof networkJson.filter.linksTag != "undefined"){
			var networkTags = [];
			//var networkTags2 = {};
			var networkTagsCategory = {};
			//var optgroupArray = {};
			tagsList = [];
			if(typeof networkJson.request.mainTag != "undefined")
				networkTags.push({id:networkJson.request.mainTag[0],text:networkJson.request.mainTag[0]});
			$.each(networkJson.filter.linksTag, function(category, properties) {
				optgroupObject=new Object;
				optgroupObject.text=category;
				optgroupObject.children=[];
				networkTagsCategory[category]=[];
				$.each(properties.tags, function(i, tag) {
					if($.isArray(tag)){
						$.each(tag, function(keyTag, textTag) {
							val={id:textTag,text:textTag};
							if(jQuery.inArray( textTag, tagsList ) == -1 ){
								optgroupObject.children.push(val);
								tagsList.push(textTag);
							}
						});
					}else{
						val={id:tag,text:tag};
						if(jQuery.inArray( tag, tagsList ) == -1 ){
							optgroupObject.children.push(val);
							tagsList.push(tag);
						}
					}
				});
				networkTags.push(optgroupObject);
				networkTagsCategory[category].push(optgroupObject);
			});
		}


		//console.warn("isMapEnd 1",isMapEnd);
		jQuery(document).ready(function() {
			setTitle(networkJson.name , "", networkJson.name+ " : "+networkJson.skin.title, networkJson.name,networkJson.skin.shortDescription);
			// Initialize tags list for network in form of element
			
			

			$(".bg-main-menu.bgpixeltree_sig").remove();
			if(myContacts != null)
			$.each(myContacts, function(type, list) {
				$.each(list, function(i, obj) {
					myContactsById[type][obj["_id"]["$id"]] = obj;
				});
			});
			//if(currentUser)
			//	organizerList["currentUser"] = currentUser.name + " (You)";

			$.each(rawOrganizerList, function(optKey, optVal) {
				organizerList[optKey] = optVal.name;
			});
			
			<?php if(isset(Yii::app()->session['userId']) && //et que le two_step est terminé
					(!isset($me["two_steps_register"]) || $me["two_steps_register"] != true)){ ?>
				
				//if(location.hostname.indexOf("localhost") >= 0) path = "/ph/";
				setCookies(location.pathname);
				
			<?php } ?>


		  	if(inseeCommunexion != "" && cpCommunexion != ""){
		  		$(".btn-menu2, .btn-menu3, .btn-menu4, .btn-menu9 ").show(400);
		  	}
		  	
		  	//$('#btn-toogle-map').click(function(e){ showMap();  	});
		    //$('.main-btn-toogle-map').click(function(e){ showMap(); });

		    $("#mapCanvasBg").show();

		    console.log("INIT scroll shadows!");
		    $(".my-main-container").bind("scroll", function(){
		    	//console.log("scrolling my-container");
		    	checkScroll();
		    	shadowOnHeader()
		    });


		    $(".btn-scope").click(function(){
		    	var level = $(this).attr("level");
		    	selectScopeLevelCommunexion(level);
		    });
		    $(".btn-scope").mouseenter(function(){
		    	$(".btn-scope").removeClass("selected");
		    });
		    $(".btn-scope").mouseout(function(){
		    	$(".btn-scope-niv-"+levelCommunexion).addClass("selected");
		    });
		    
		    initNotifications();
			initFloopDrawer();
		    
		    $(window).resize(function(){
		      resizeInterface();
		    });

		    resizeInterface();
		    showFloopDrawer();

		    if(cityNameCommunexion != ""){
				$('#searchBarPostalCode').val(cityNameCommunexion);
				$(".search-loader").html("<i class='fa fa-check'></i> Vous êtes communecté à " + cityNameCommunexion + ', ' + cpCommunexion);
			}

			toogleCommunexion();

			
			//manages the back button state 
			//every url change (urlCtrl.loadByHash) is pushed into history.pushState 
			//onclick back btn popstate is launched
			//
		    $(window).bind("popstate", function(e) {
		      //console.dir(e);
		      console.log("history.state",$.isEmptyObject(history.state),location.hash);
		      console.warn("popstate history.state",history.state);
		      if( lastUrl && "onhashchange" in window && location.hash  ){
		        if( $.isEmptyObject( history.state ) && allReadyLoad == false ){
			        //console.warn("poped state",location.hash);
			        //lastUrl = location.hash;
			        urlCtrl.loadByHash(location.hash,true);
			    } 
			    allReadyLoad = false;
		      }
			  
		      lastUrl = location.hash;
		    });


			//console.log("start timeout MAIN MAP LOOOOOL");
			//$("#btn-toogle-map").hide();
			


		    //console.warn("hash", location.hash);
		    //console.warn("isMapEnd 3",isMapEnd);
		    //console.log("userConnected");
			//console.dir(userConnected);
			//si l'utilisateur doit passer par le two_step_register
			//window.location=window.location;
			if(userConnected != null && userConnected != "" && typeof userConnected != "undefined" && !location.hash){
				//location.search="?network="+networkParams
				//console.warn("hash 1", location.hash);
				//urlCtrl.loadByHash("#network.simplydirectory");
				return;
			} 
			else{ //si l'utilisateur est déjà passé par le two_step_register
		 		if(location.hash != "#network.simplydirectory" && location.hash != "#" && location.hash != ""){
		 			console.warn("hash 2", location.hash);
		 			//getAjaxFiche(location.hash,0);
					urlCtrl.loadByHash(location.hash);
					return;
				}
				else{ 
					return;
					//console.log("userConnected", userConnected);
					//console.warn("hash3", location.hash);
					if(userConnected != null && userId != null  && userId != "" && typeof userId != "undefined")
						urlCtrl.loadByHash("#default.live");//news.index.type.citoyens.id."+userId);
					else
						urlCtrl.loadByHash("#default.live");
				}
			}
			checkScroll();
		});

		
		</script>

		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
	</body>
	<!-- end: BODY -->
</html>