
<!-- Modal -->
<!-- TODO - Refactor -->
<div class="modal  fade" id="participer"  tabindex="-1" role="dialog" aria-labelledby="participerLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="participerLabel">Inscription réussie, Étape suivante ?</h3>
  </div>
  <div class="modal-body" style="max-height:550px" >
  <p> Un mail de validation vous a été envoyé
   <br/>En attendant vous pouvez compléter votre inscription ci-dessous</p>
    <form id="register2" style="line-height:40px;">
        <section>
          
          	
          	<table>
              	<tr>
                  	<td class="txtright"></td>
                  	<td> <?php if($account && isset($account['email']) )echo $account['email'] ?></td>
              	</tr>
              	<tr>
                  	<td class="txtright">Je m'appelle</td>
                  	<td> <input id="registerName" name="registerName" value="<?php if($account && isset($account['name']) )echo $account['name'] ?>"/></td>
              	</tr>
              	<tr>
                  	<td class="txtright"><img width=50 class="citizenThumb" src="<?php echo ( $account && isset($account['img']) ) ? Yii::app()->createUrl($account['img']) : Yii::app()->createUrl('images/PHOTO_ANONYMOUS.png'); ?>"/></td>
                  	<td> <?php
                        $this->widget('yiiwheels.widgets.fineuploader.WhFineUploader', array(
                                'name'          => 'imageCitoyenFile',
                                'uploadAction'  => $this->createUrl('index.php/templates/upload/dir/citoyens/input/imageCitoyenFile', array('fine' => 1)),
                                'pluginOptions' => array(
                                    'validation'=>array(
                                        'allowedExtensions' => array('jpg','jpeg','png','gif'),
                                        'itemLimit'=>1
                                    )
                                ),
                                'events' => array(
                                    'complete'=>"function( id,  name,  responseJSON,  xhr){
                                    console.log('".Yii::app()->createUrl('upload/citoyens/')."/'+xhr.name+'?d='+ new Date().getTime());
                                    $('#imageCitoyen').val('upload/citoyens/'+xhr.name);
                                    $('img.citizenThumb').attr('src','".Yii::app()->createUrl('upload/citoyens/')."/'+xhr.name+'?d='+ new Date().getTime());
                                    }"
                                ),
                            ));
                        ?>
                        <input type="hidden" id="imageCitoyen" name="imageCitoyen" value="<?php if($account && isset($account["image"]))echo $account["image"]?>"/>
                    </td>
              	</tr>
              	<?php /*?>
              	<tr>
                  	<td class="txtright">Je suis  </td>
                  	<td>
                  	<?php 
                          $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                            'data' => array("citoyen"=>"citoyen","association"=>"association","entreprise"=>"entreprise","collectivité"=>"collectivité"), 
                            'name' => 'typePA',
                          	'id' => 'typePA',
                            'value'=>($account && isset($account['type']) ) ? $account['type'] : "citoyen",
                            'pluginOptions' => array('width' => '150px')
                          ));
            		    ?></td>
        		</tr>   
        		<?*/?>
        		<input id="typePA" name="typePA" type="hidden" value="citoyen"/>
        		<tr>
                  	<td class="txtright">j'habite en  </td>
                  	<td>
        		<?php 
                          $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                            'data' => OpenData::$phCountries, 
                            'name' => 'countryPA',
                          	'id' => 'countryPA',
                            'value'=>($account && isset($account['country']) ) ? $account['country'] : "Réunion",
                            'pluginOptions' => array('width' => '150px')
                          ));
            		    ?></td>
            	</tr> 
        		<tr>
            		<td class="txtright">au code postal</td>  
            		<td><input id="registerCP" name="registerCP" class="span2" value="<?php if($account && isset($account['cp']) )echo $account['cp'] ?>"></td>
        		</tr>
        		
        		<tr> 
                    <td class="txtright">J'aimerais aider le projet</td>
                    <td> <input type="checkbox" id="registerHelpout" name="registerHelpout" <?php if($account && isset($account['activeOnProject']) )echo "checked" ?>></td>
                </tr>
                <tr <?php if($account && (!isset($account['activeOnProject']) || !$account['activeOnProject']) ){ ?>class="hidden" <?php }?> id="registerHelpoutWhat">
                    <td class="txtright">en tant que </td>
                    <td>
                        <?php 
                          $cursor = PHDB::findOne(PHType::TYPE_JOBTYPES, array(), array('list'));
                          $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                            'asDropDownList' => false,
                            'name' => 'helpJob',
                          	'id' => 'helpJob',
                            'value'=>($account && isset($account['positions']) ) ? implode(",", $account['positions']) : "",
                            'pluginOptions' => array(
                                'tags' => $cursor['list'],
                                'placeholder' => "Qu'aimeriez vous faire ?",
                                'width' => '100%',
                                'tokenSeparators' => array(',', ' ')
                            )));
            		    ?>
        		    </td>
    		    </tr>
    		    
    		    <tr >
                    <td class="txtright">Centre d'intérêt </td>
                    <td>
                        <?php 
                          /*$cursor = PHDB::findOne(PHType::TYPE_LISTS, array("name"=>"tags"), array('list'));
                          $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                            'asDropDownList' => false,
                            'name' => 'tagsPA',
                          	'id' => 'tagsPA',
                            'value'=>($account && isset($account['tags']) ) ? implode(",", $account['tags']) : "",
                            'pluginOptions' => array(
                                'tags' => $cursor['list'],
                                'placeholder' => "Mots clefs vous décrivant",
                                'width' => '100%',
                                'tokenSeparators' => array(',', ' ')
                            )));*/
            		    ?>
        		    </td>
    		    </tr>
          </table>
             
        </section>
        
    </form>
    <p>Toute l'équipe du Pixel Humain vous remercie et vous souhaites la bienvenue.</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Fermer</button>
    <button class="btn btn-primary" id="submitAccount" onclick="$('#register2').submit();">Enregistrer</button>
  </div>
</div>
</div>
</div>
<!-- Modal -->
<script type="text/javascript">
initT['AccountModalsInit'] = function(){
    $("#register2").submit( function(event){
    	event.preventDefault();
    	$("#participer").modal('hide');
    	toggleSpinner();
    	$.ajax({
    	  type: "POST",
    	  url: baseUrl+"/index.php/citoyens/register2",
    	  data: $("#register2").serialize(),
    	  success: function(data){
    			  $("#flashInfo .modal-body").html(data.msg);
    			  
    		  	  toggleSpinner();
    		  	  if(data.newAsso){
        		  	  alert("L'association "+data.newAsso+" a été créé pour vous, merci d'inviter le président pour confirmer.");
    		  		  $("#invitation").modal('show');
    		  	  } else
    		  		$("#flashInfo").modal('show');
    	  },
    	  dataType: "json"
    	});
    });

    showEvent("registerHelpout");
};

</script>