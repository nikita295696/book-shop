<?php
/** @var array $book */

?>
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <?php if($book !== null) { ?>
            <?= \models\widjets\BreadcrampWidjet::renderBook($book)?>
            <!--  Product Details -->
            <div class="product product-details clearfix">

                <div class="col-md-6">
                    <?php $img = count($book["photos"]) > 0 ? $book["photos"][0]['path'] : PUBLIC_URL."images/book.jpg"; ?>
                    <div id="product-main-view" class="slick-initialized slick-slider">
                        <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 2220px;"><div class="product-view slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" tabindex="0" style="width: 555px; position: relative; left: 0px; top: 0px; z-index: 999; opacity: 1; overflow: hidden;">
                                    <img src="<?=$img?>" alt="">
                                    <img role="presentation" src="<?=$img?>" class="zoomImg" style="position: absolute; top: -300.964px; left: -485.203px; opacity: 0; width: 1200px; height: 1200px; border: none; max-width: none; max-height: none;"></div><div class="product-view slick-slide" data-slick-index="1" aria-hidden="true" tabindex="-1" style="width: 555px; position: relative; left: -555px; top: 0px; z-index: 998; opacity: 0; overflow: hidden;">
                                    <img src="<?=$img?>" alt="">
                                    <img role="presentation" src="<?=$img?>" class="zoomImg" style="position: absolute; top: 0px; left: 0px; opacity: 0; width: 1200px; height: 1200px; border: none; max-width: none; max-height: none;"></div><div class="product-view slick-slide" data-slick-index="2" aria-hidden="true" tabindex="-1" style="width: 555px; position: relative; left: -1110px; top: 0px; z-index: 998; opacity: 0; overflow: hidden;">
                                    <img src="<?=$img?>" alt="">
                                    <img role="presentation" src="<?=$img?>" class="zoomImg" style="position: absolute; top: 0px; left: 0px; opacity: 0; width: 1200px; height: 1200px; border: none; max-width: none; max-height: none;"></div><div class="product-view slick-slide" data-slick-index="3" aria-hidden="true" tabindex="-1" style="width: 555px; position: relative; left: -1665px; top: 0px; z-index: 998; opacity: 0; overflow: hidden;">
                                    <img src="<?=$img?>" alt="">
                                    <img role="presentation" src="<?=$img?>" class="zoomImg" style="position: absolute; top: 0px; left: 0px; opacity: 0; width: 1200px; height: 1200px; border: none; max-width: none; max-height: none;"></div></div></div>



                        </div>
                </div>
                <div class="col-md-6">
                    <div class="product-body">
                        <?php $bookData = $book['data']; ?>

                        <div class="product-label">

                        </div>
                        <h2 class="product-name"><?=  $bookData['name']?></h2>
                        <h3>Publisher: <?=$bookData['publisherName']?></h3>

                        <p><strong>Year publisher:</strong> <?=$bookData['yearPublisher']?> </p>
                        <p><strong>Authors:</strong>
                            <?php foreach ($book['authors'] as $author){ ?>
                                <span class=""><?=$author['name']?></span>
                            <?php } ?>
                        </p>

                    </div>
                </div>
            </div>
            <!-- /Product Details -->
            <?php } else { ?>
                <h2>Not found book</h2>
            <?php } ?>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
