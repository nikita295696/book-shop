<?php
/** @var array $breadcramp */
?>
<div id="store">
    <!-- row -->
    <div class="row">

        <?= \models\widjets\BreadcrampWidjet::render(isset($breadcramp) ? $breadcramp : null)?>
        <div class="col-md-12">
            <div class="section-title">
                <?php if(!isset($books)) {?>
                    <h2 class="title">Welcome to books shop. Choose a category for displaying books</h2>
                <?php }else if(is_array($books) && count($books) > 0) { ?>
                    <h2 class="title">Books</h2>
                <?php }else{ ?>
                    <h2 class="title">Not found books to this categories</h2>
                <?php } ?>
            </div>
        </div>

        <?php
        if(isset($books)) {
            foreach ($books as $book) { ?>
                <!-- Product Single -->
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product product-single">
                        <div class="product-thumb">
                            <a href="<?= Application::getUrl("products", "view", $book['id']) ?>"
                               class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</a>
                            <img src="<?= PUBLIC_URL ?>images/book.jpg" alt="">
                        </div>
                        <div class="product-body">
                            <h3>Year publisher: <?=$book['yearPublisher']?></h3>
                            <h2 class="product-name"><a
                                        href="<?= Application::getUrl("products", "view", $book['id']) ?>"><?= $book['name'] ?></a>
                            </h2>
                        </div>
                    </div>
                </div>
                <!-- /Product Single -->
            <?php
            }
        }?>
    </div>
    <!-- /row -->
</div>