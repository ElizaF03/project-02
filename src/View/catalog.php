<head>
    <title>Food Delivery Website</title>

</head>
<body>
<main class="dashboard">
    <article class="restaurant-panel">

        <section class="section" id="restaurants">
            <div class="section-titles">
                <div class="section-title">Catalog</div>
            </div>
            <div class="section-titles">
                <a href="/favorites" class="button">Favorites</a>
                <a href="/cart" class="button">Cart <span>(<?php echo $sum; ?>)</span></a>
                <a href="/logout" class="button">Exit</a>
            </div>
        </section>
        <section class="section">
            <ul class="restaurant-list">
                <?php foreach ($products as $product): ?>
                    <li class="restaurant-list__item">
                        <form action="/product-card" method="post">
                            <input type="text" value="<?php echo $product->getId(); ?>" name="id-product"
                                   hidden="hidden">
                            <button class="button-img" type="submit"><img class="restaurant-image"
                                                                          src="<?php echo $product->getImgUrl(); ?>"/>
                            </button>
                        </form>


                        <div class="restaurant-info">
                            <div class="restaurant-name"><?php echo $product->getName(); ?></div>
                            <span class="restaurant-category"><?php echo $product->getPrice(); ?> $</span>
                            <div class="action">
                                <form class="form" method="post" action="/add-product">
                                    <input type="text" value="<?php echo $product->getId(); ?>" name="id-product"
                                           hidden="hidden">
                                    <button class="button" type="submit">+</button>
                                </form>

                                <form class="form" method="post" action="/remove-product">
                                    <input type="text" value="<?php echo $product->getId(); ?>" name="id-product"
                                           hidden="hidden">
                                    <button class="button" type="submit">-</button>
                                </form>
                                <div class="add_favorite">
                                    <form class="form" method="post" action="/favorites">
                                        <input type="text" value="<?php echo $product->getId(); ?>" name="id-product"
                                               hidden="hidden">
                                        <button class="button" type="submit">Add to favorites</button>
                                    </form>
                                </div>
                            </div>

                        </div>

                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </article>

</main>
<style>
    @import url("https://fonts.googleapis.com/css?family=Roboto:400,400i,700");

    body {
        margin: 0;
        min-height: 100vh;
        font-size: 14px;
        font-family: Roboto, sans-serif;
        background: var(--warning-color);
    }

    :root {
        --danger-color: rgb(250, 83, 24);
        --danger-color-lighter: rgb(255, 247, 237);
        --warning-color: rgb(252, 213, 97);
        --warning-color-transparent: rgba(252, 213, 97, 0.1);
        --secondary-color: rgb(248, 248, 247);
        --secondary-color-darker: rgb(160, 160, 160);
        --secondary-color-lightest: rgb(253, 253, 251);
        --info-color: rgb(80, 62, 157);
    }

    .action {
        display: flex;
        margin-top: 10px;

    }

    .button-img {
        position: relative;
        padding: 0;
        border: 0;
        cursor: pointer;

        img {

            width: 100%;
            height: 100%;
        }
    }

    .button {
        display: flex;
        color: #006653;
        font-size: 22px;
        padding: 5px;
        min-width: 30px;
        justify-content: center;
    }

    .dashboard {
        margin: 8px;
        background: white;
        border-radius: 30px;
    }

    .restaurant-panel {
        padding: 45px 80px;
        border-right: 1px solid var(--secondary-color);
    }


    #restaurants .section-titles {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    #restaurants .section-titles .section-title {
        font-size: 21px;
        font-weight: bold;
    }

    .category-list__item a {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
    }


    .category-list__item .category-icon svg {
        fill: black;
        transform: scale(1.2);
    }

    .restaurant-list {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 25px;
        padding: 0;
        margin: 0;
        list-style-type: none;
    }

    .restaurant-list__item {
        width: 350px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: white;
    }

    .button-img {
        width: 210px;
        height: 250px;
        background-color: white;
        img {
            height: 100%;
            width: 100%;
            object-fit: contain;
        }
    }

    .restaurant-list__item .restaurant-name {
        margin-top: 27px;
        font-size: 26px;
    }

    .restaurant-info {
        display: flex;
        flex-direction: column;
        text-align: center;
        justify-content: center;
        align-items: center;
        margin-top: 12px;
        font-size: 10px;
    }

    .restaurant-list__item .restaurant-rate > * {
        display: inline-flex;
        vertical-align: middle;
    }

    .restaurant-list__item .restaurant-rate svg {
        margin-right: 6px;
    }

    .restaurant-list__item .restaurant-category {
        color: black;
        font-size: 22px;
    }

    .button {
        background-color: #006653;
        margin-left: 15px;
        color: #ffffff;
        padding: 5px;
        cursor: pointer;
    }

</style>
</body>
