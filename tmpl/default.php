<?php
defined('_JEXEC') or die('Restricted access');
$title              =       $params->get( 'showtitle', 0 );
$textlength         =       $params->get( 'textlength', 100 );
$navigation         =       $params->get( 'navigation', 1 ) == 1 ? 'true' : 'false';
$pagination         =       $params->get( 'pagination', 1 ) == 1 ? 'true' : 'false';
$items_toshow       =       $params->get( 'items_toshow', 4);
$intro              =       $params->get( 'intro', '' );
$image_default      =       JURI::base( true ) . "/" . $params->get( 'image_default', '' );
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
			<?php 
			$link = modMD18LastNewsHelper::getLink($options[$i]); 
			$catRoute = ContentHelperRoute::getCategoryRoute($options[$i]->catid, $options[$i]->catid);
			$categoryLink = JRoute::_($catRoute); 
			?>
		    <div class="item">
				
				<div class="item-category-name">
					<a href="<?php echo $categoryLink; ?>" title="<?php echo $options[$i]->category_title; ?>">
						<?php echo $options[$i]->category_title; ?>
					</a>
				</div>

				<div class="item-date">
					<div class="date-value">
		            	<?php echo JHtml::date($options[$i]->created , 'd/m/Y'); ?>
		            </div>
		        </div>

		        <!-- Image intro -->
		        <?php $images = json_decode($options[$i]->images); ?>
		        <?php if($images->image_intro){ ?>
			        <div>
			            <a href="<?php echo $link; ?>" title="<?php echo $options[$i]->title; ?>">
			            	<img src="<?php echo $images->image_intro; ?>" alt="<?php echo $images->image_intro_alt; ?>" class="item-picture" />
			            </a>
			        </div>
		        
		        <!-- Image default -->
		        <?php } else { ?>
			        <div>
			            <a href="<?php echo $link; ?>" title="<?php echo $options[$i]->title; ?>">
			            	<img src="<?php echo $image_default; ?>" alt="" class="item-picture" />
			            </a>
			        </div>
		        <?php } ?>
		        
		        <!-- Title -->
		        <h3 class="item-title">
		            <a href="<?php echo $link; ?>" title="<?php echo $options[$i]->title; ?>">
		                <?php if (strlen($options[$i]->title) > 29) : ?>
		                	<?php echo (substr($options[$i]->title, 0, 30) . "..."); ?>
		                <?php else : ?>
		                	<?php echo $options[$i]->title; ?>
		            	<?php endif; ?>
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

		        <a href="<?php echo $link; ?>" class="btn-read-more" title="<?php echo $options[$i]->title; ?>">
		        Leia mais
		        </a>

			</div>

		<?php endfor; ?>
	</div>
    <script>
        "use strict";
        
        !function($){
        
            $(document).ready(function(){

                var carousel = $('#latestnews-carousel').owlCarousel({
                    items: <?php echo $items_toshow ?>,
                    /*itemsCustom : true,*/
        			itemsDesktop : [1650, 5],
        			itemsDesktopSmall: [1300, 4],
        			itemsTablet : [992, 3],
        			itemsTabletSmall : [640, 2],
        			itemsMobile : [500, 1],
                    navigation : <?php echo $navigation; ?>, // Show next and prev buttons
                    pagination: <?php echo $pagination; ?>,
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
