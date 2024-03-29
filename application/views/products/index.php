<div class="col-lg-8 offset-lg-0">
    <!-- <h3 class="text-center">Proizvodi</h3> -->

        <?php if (!isset($_GET['category_id'])) {
            $kategorija_id = $products[0]['categories_id'];
            $kategorija = '';
        } else {
            $kategorija_id = $_GET['category_id'];
        }
        switch ($kategorija_id) {
            case 1:
                $kategorija = 'Lemilice i propratna oprema';
                break;
            case 2:
                $kategorija = 'Manualni sistemi';
                break;
            case 3:
                $kategorija = 'Izvlačenje isparenja';
                break;
            case 4:
                $kategorija = 'Automatski sistemi';
                break;
            case 5:
                $kategorija = 'Oprema za vizuelnu kontrolu';
                break;
            case 6:
                $kategorija = 'Roboti';
                break;
            case 7:
                $kategorija = 'Antistatički program';
                break;
        }

        if (isset($_GET['subcategory'])) {

            switch ($_GET['subcategory']) {
                case 'Lemilice':
                    $podkategorija = 'Lemilice';
                    break;
                case 'Predgrejači':
                    $podkategorija = 'Predgrejači';
                    break;
                case 'Odeća':
                    $podkategorija = 'Antistatička odeća';
                    break;
                case 'Podovi':
                    $podkategorija = 'Antistatički podovi';
                    break;
                case 'p-and-p':
                    $podkategorija = 'Pick and Place mašine';
                    break;
                case 'Propratni-materijal':
                    $podkategorija = 'Propratni materijal';
                    break;
                case 'Manualni-printeri':
                    $podkategorija = 'Manualni štampači';
                    break;
                case 'Desktop-peći':
                    $podkategorija = 'Desktop peći';
                    break;
                case "Manualni-polagač":
                    $podkategorija = 'Manualni SMD polagač';
                    break;
                case 'Peći-lemljenje':
                    $podkategorija = 'Peći za lemljenje';
                    break;
                case 'Talasno-lemljenje':
                    $podkategorija = 'Sistemi za talasno-lemljenje';
                    break;
                case 'Optička-inspekcija':
                    $podkategorija = 'Sistemi za optičku inspekciju';
                    break;
                case 'Stencile-printeri':
                    $podkategorija = 'Stencile štampači';
                    break;
                case 'Automatski-dodaci':
                    $podkategorija = 'Dodatna oprema za automatske sisteme';
                    break;
                case 'Stanica-vazduh':
                    $podkategorija = 'Stanice za topli vazduh';
                    break;
                case 'Podloge':
                    $podkategorija = 'Antistatik podloge';
                    break;
                case 'Narukvice':
                    $podkategorija = 'Antistatik narukvice i kablovi';
                    break;
                case 'Kese':
                    $podkategorija = 'Antistatik kese';
                    break;
                case 'Rukavice':
                    $podkategorija = 'Antistatik rukavice';
                    break;
                case 'Testeri':
                    $podkategorija = 'steri i merna ESD oprema';
                    break;
                case 'Stolice':
                    $podkategorija = 'Antistatik stolice';
                    break;
                case 'Stolovi':
                    $podkategorija = 'Antistatik radni stolovi';
                    break;
                case 'Kutije':
                    $podkategorija = 'Antistatik kutije';
                    break;
                case 'Četke':
                    $podkategorija = 'Antistatik četke';
                    break;
                case 'Trake':
                    $podkategorija = 'Trake i nalepnice za upozoravanje';
                    break;
                case 'Jonizatori':
                    $podkategorija = 'Jonizatori';
                    break;
                case 'Hemija':
                    $podkategorija = 'ESD hemijska sredstva';
                    break;
                case 'Dodatak':
                    $podkategorija = 'Dodatna oprema';
                    break;
            }

            echo '<ul class="breadcrumb"><li><a href="' . base_url() . 'products">Proizvodi</a></li>';
            echo '<li><a href="' . base_url() . 'products/?category_id=' . $products[0]['categories_id'] . '">' . $kategorija . '</a></li>';
            echo '<li><a href="' . base_url() . 'products/?subcategory=' . $_GET['subcategory'] . '">' . $podkategorija . '</a></li>';
            echo '</ul>';
        } elseif (!isset($_GET['subcategory']) && isset($_GET['category_id'])) {
            echo '<ul class="breadcrumb"><li><a href="' . base_url() . 'products">Proizvodi</a></li>';
            echo '<li><a href="' . base_url() . 'products/?category_id=' . $kategorija_id . '">' . $kategorija . '</a></li>';
            echo '</ul>';
        } else {
            if (!isset($_GET['category_id']) && !isset($_GET['subcategory'])) {
                echo '<ul class="breadcrumb"><li><a href="' . base_url() . 'products">Proizvodi</a></li>';
            }

            echo '</ul>';
        }
        ?>
        <!-- <h2 class="text-center">Naši proizvodi</h2> -->
        <?php foreach ($products as $product) : ?>
            <div class="product-card-small">
                <div class="d-flex justify-content-between">
                    <h4><b><?php echo $product['title'] ?></b> <?php if ($this->session->userdata('logged_in')) : ?>
                            <b><?php echo "<br>Redni broj proizvoda je: " . $product['rb'] ?></b>
                        <?php endif; ?>
                    </h4>
                    <h6><small><i>Proizvođač:</i></small> <b><?php echo $product['proizvodjac'] ?></b></h6>

                </div>
                <div class="row no-gutters">
                    <div id="img-sm-center" class="col-sm-12 col-md-5 text-center">

                        <img src="<?php echo base_url(); ?>assets/img/productimg/<?php echo $product['product_image'] ?>" alt="tmt-9000s-small">
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <ul class="ml-md-5">
                            <?php $karakter_niz = explode(', ', $product['karakteristike']);
                            $novi_niz = array($karakter_niz[0], $karakter_niz[1] ?? "-", $karakter_niz[2] ?? "-");
                            ?>
                            <?php foreach ($novi_niz as $string) : ?>
                                <li><?php echo $string ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php if (!empty($product['sizes'])) : ?>
                    <?php $velicine_niz = explode(';', $product['sizes']);
                    ?>
                    <div class="row justify-content-center">
                        <div class="col-4" style="border-bottom: 1px dotted;">Šifra</div>
                        <div class="col-4 text-right" style="border-bottom: 1px dotted">Veličina</div>
                    </div>
                    <?php foreach ($velicine_niz as $string) : ?>
                        <div class="row justify-content-center">
                            <?php $par = explode(':', $string); ?>
                            <div class="col-4" style="border-bottom: 1px dotted;"><?php echo $par[0] ?></div>
                            <div class="col-4 text-right" style="border-bottom: 1px dotted"><?php echo $par[1] ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <p class="text-justify"><?php echo word_limiter($product['opis'] , 15); ?></p>
                <p class="text-primary"><a href="<?php echo site_url('products/' . $product['slug']); ?>">Više o
                        proizvodu</a>
                </p>
            </div>
        <?php endforeach; ?>
        <div class="pagination-links">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>

