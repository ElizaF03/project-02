<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
</head>
<body>
<article class="order-panel">
    <section class="section" id="order">
        <div class="section-title">My Order 😎</div>

        <div class="section-titles">
            <a href="/catalog" class="button">In catalog</a>
            <a href="/logout" class="button">Exit</a>
        </div>
        <div class="body-order">
            <div class="left-column">
                <ul class="food-list">
                    <?php foreach ($products as $product): ?>
                    <li class="food-list__item">
                        <div class="food-info">
                            <img class="food-image"
                                 src=<?php echo $product['img_url']; ?>/>
                            <div class="food-buy-amount"><?php  ?>  x</div>
                            <div class="food-name"><?php echo $product['name']; ?>
                            </div>
                        </div>

                        <div class="food-price"><?php echo $product['price']; ?> $</div>
                    </li>

                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="right-column">
                <div class="total-price">
                    <div class="total">Total:</div>
                    <div class="price">$25.97</div>
                </div>
                <div class="buy-action">
                    <button class="btn btn-warning checkout-btn">
                        Buy
                        <svg width="18" height="18" class="arrow" viewBox="0 0 24 24">
                            <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                        </svg>
                    </button>
                </div>
            </div>

        </div>

    </section>
</article>

</body>
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

    .order-panel {
        padding: 56px 50px 42px 48px;
        background: var(--secondary-color-lightest);
    }
    .section-titles {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        font-size: 21px;
        font-weight: bold;
        margin: 20px 0;
    }

    .body-order {
        display: flex;
        gap: 250px;
    }

    .food-list {
        display: flex;
        flex-direction: column;
        gap: 30px;
        padding: 0;
        width: 900px;
        margin: 54px auto;
        font-size: 22px;
        font-weight: bold;
        list-style-type: none;
    }

    .food-list__item {
        display: flex;
        align-items: center;
        justify-content: space-between;

    }

    .food-buy-amount {
        width: 130px;
    }

    .food-list__item .food-image {
        width: 250px;
        height: 125px;
        object-fit: cover;
        border-radius: 15px;
        margin-right: 20px;
    }

    .food-info {
        display: flex;
        align-items: center;
    }

    .food-name {
        margin-left: 15px;
    }

    .food-list__item .food-price {
        color: var(--secondary-color-darker);
        margin-left: 15px;
    }

    .total-price {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 115px;
        padding-bottom: 24px;
    }

    .total-price .price {
        font-size: 22px;
        font-weight: bold;
    }

    .total-price .total {
        font-size: 22px;
    }

    .buy-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 34px;
        border-top: 2px solid var(--secondary-color-lighter);
    }

    .buy-action .checkout-btn {
        display: flex;
        align-items: center;
        padding: 30px;
        color: black;
        border-radius: 10px;
    }

    .buy-action .checkout-btn .arrow {
        margin-left: 16px;
    }
    .button{
        background-color: #006653;
        margin-left: 15px;
        color: #ffffff;
        padding: 5px;
        cursor: pointer;
    }
</style>
</html>