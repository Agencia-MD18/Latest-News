<?php
defined('_JEXEC') or die('Restricted access');
$title              =       $params->get( 'showtitle', 0 );
$textlength         =       $params->get( 'textlength', 100 );
$navigation         =       $params->get( 'navigation', 1 ) == 1 ? 'true' : 'false';
$items_toshow       =       $params->get( 'items_toshow', 4);
$intro              =       $params->get( 'intro', '' );
$menuitem           =       $params->get( 'menuitem', '' );

?>

<link rel="stylesheet" type="text/css" href="modules/mod_md18_latestnews/tmpl/css/md18_latestnews.css" />

<div id="md18_lastnews" class="md18-latestnews">
    
    <?php /* Text of Introduction */ ?>
    <?php if ($intro) { ?>
        <?php echo $intro; ?>
    <?php } ?>
    
    <?php /* Carousel */ ?>
	<div id="latestnews-carousel" class="owl-carousel">
    <?php for ($i = 0, $n = count($options); $i < $n; $i ++) : ?>
        <?php $link = modMD18LastNewsHelper::getLink($options[$i], $menuitem); ?>
        <div class="item">
			
            <!-- Image -->
            <?php $images = json_decode($options[$i]->images); ?>
            <?php if($images->image_intro){ ?>
            <div>
                <a href="<?php echo $link; ?>" title="<?php echo $options[$i]->title; ?>">
                    <img src="<?php echo $images->image_intro; ?>" alt="<?php echo $images->image_intro_alt; ?>" class="item-picture" />
                </a>
            </div>
            <?php } ?>
            
            <!-- Title -->
            <h3 class="item-title">
                <a href="<?php echo $link; ?>" title="<?php echo $options[$i]->title; ?>">
                    <?php echo $options[$i]->title; ?>
                </a>
            </h3>

            <!-- Content -->
            <div class="item-content">
            <?php 
            if($options[$i]->introtext) {
                if (strlen($options[$i]->introtext) >= 14){
                    echo (substr($options[$i]->introtext, 0, $textlength). "...");
                } else {
                    echo($options[$i]->introtext);
                }
            }
            else{
                if (strlen($options[$i]->fulltext) >= 14){
                    echo (substr($options[$i]->fulltext, 0, $textlength). "...");
                } else {
                    echo($options[$i]->fulltext);
                }
            }
            ?>
            </div>

            <div class="item-date">
                <?php echo JHtml::date($options[$i]->created , 'd.m.Y'); ?>
            </div>

		</div>

    <?php endfor; ?>
	</div>
    <script>
        "use strict";
        
        !function($){
        
            $(document).ready(function(){

                var carousel = $('#latestnews-carousel').owlCarousel({
                    items: <?php echo $items_toshow ?>,
                    navigation : <?php echo $navigation; ?>, // Show next and prev buttons
                    slideSpeed : 300,
                    paginationSpeed : 400,
                    autoPlay: false,
                    disabledEvents :  function () {
                      var base = this;

                      base.$elem.on("dragstart.owl", function (event) { event.preventDefault(); });

                      if (base.options.mouseDrag == true) {
                        base.$elem.on("mousedown.disableTextSelect", function (e) {
                          return $(e.target).is('input, textarea, select, option');
                        });
                      }
                    }
                });
        
            });
        
        }(jQuery);

        
    </script>

</div>

