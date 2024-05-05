<div class="container">
    <input type="checkbox" id="check">
    <div class="registration form">
        <header>Order</header>
        <form action="/order" method="post">
            <div class="form-wrapper">
                <div class="input-wrapper">
                    <label for="first-name"
                           style="color: crimson"><?php if (!empty($errors['first-name'])) echo $errors['first-name']; ?></label>
                    <input type="text" name="first-name" placeholder="Enter your first name"
                           value="<?php if (!empty($_POST['first-name'])) {
                               echo $_POST['first-name'];
                           } ?>">
                    <label for="last-name"
                           style="color: crimson"><?php if (!empty($errors['last-name'])) echo $errors['last-name']; ?></label>
                    <input type="text" name="last-name" placeholder="Enter your last name"
                           value="<?php if (!empty($_POST['last-name'])) {
                               echo $_POST['last-name'];
                           } ?>">
                    <label for="address"
                           style="color: crimson"><?php if (!empty($errors['address'])) echo $errors['address']; ?></label>
                    <input type="text" name="address" placeholder="Enter your address">
                    <label for="phone"
                           style="color: crimson"><?php if (!empty($errors['phone'])) echo $errors['phone']; ?></label>
                    <input type="tel" name="phone" placeholder="Enter your phone">
                </div>

                <div class="body-order">
                    <div class="left-column">
                        <ul class="food-list">
                            <?php $totalSum = 0; ?>
                            <?php foreach ($products as $product): ?>
                                <li class="food-list__item">
                                    <div class="food-info">
                                        <img class="food-image"
                                             src=<?php echo $product['img_url']; ?>/>
                                        <div class="food-buy-amount"><?php echo $product['quantity']; ?> x</div>
                                        <div class="food-name"><?php echo $product['name']; ?>
                                        </div>
                                    </div>
                                    <div class="food-price"><?php echo $product['price']; ?> $</div>
                                    <?php $sum = $product['price'] * $product['quantity']; ?>
                                </li>
                                <?php $totalSum = $totalSum + $sum; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="right-column">
                        <div class="total-price">
                            <div class="total">Total:</div>
                            <div class="price">
                                <?php echo $totalSum; ?> $
                            </div>
                            <label for="price"
                                   style="color: crimson"><?php if (!empty($errors['total-price'])) echo $errors['total-price']; ?></label>
                            <input type="text" name="total-price" hidden="hidden"
                                   value="<?php echo $totalSum; ?>">
                        </div>

                    </div>

                </div>
            </div>
            <button type="submit" class="button" value="makeOrder">Make Order</button>
        </form>
    </div>
</div>
<style>

    #check:checked ~ .registration {
        display: block;
    }

    #check:checked ~ .login {
        display: none;
    }

    #check {
        display: none;
    }

    .container .form {
        padding: 2rem;
    }
.form-wrapper{
    display: flex;
    gap: 30px;
}
    .form header {
        font-size: 2rem;
        font-weight: 500;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .form input {
        height: 60px;
        width: 100%;
        padding: 0 15px;
        font-size: 17px;
        margin-bottom: 1.3rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        outline: none;
    }

    .button {
        height: 60px;
        width: 100%;
        padding: 0 15px;
        font-size: 17px;
        margin-bottom: 1.3rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        outline: none;
        cursor: pointer;
        text-decoration: none;
        background: #006653;
        color: #dddddd;
    }

    .form input:focus {
        box-shadow: 0 1px 0 rgba(0, 0, 0, 0.2);
    }

    .form a {
        font-size: 16px;
        color: #009579;
        text-decoration: none;
    }

    .form a:hover {
        text-decoration: underline;
    }

    .form input.button {
        color: #fff;
        background: #009579;
        font-size: 1.2rem;
        font-weight: 500;
        letter-spacing: 1px;
        margin-top: 1.7rem;
        cursor: pointer;
        transition: 0.4s;
    }

    .form input.button:hover {
        background: #006653;
    }


    .signup label {
        color: #009579;
        cursor: pointer;
    }

    .signup label:hover {
        text-decoration: underline;
    }



    .food-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding: 0;
        margin: 0 auto;
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
        width: 90px;
    }

    .food-list__item .food-image {
        width: 50px;
        height: 35px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 10px;
    }

    .food-info {
        display: flex;
        align-items: center;
    }

    .food-name {

    }

    .food-list__item .food-price {
        color: var(--secondary-color-darker);
        margin-left: 45px;
    }

    .total-price {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        padding-bottom: 24px;
    }

    .total-price .price {
        font-size: 22px;
        font-weight: bold;
    }

    .total-price .total {
        font-size: 22px;
    }

</style>
