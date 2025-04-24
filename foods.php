
    <?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                //Display Foods that are Active
                $sql = "SELECT * FROM tbl_food WHERE active='Yes'";

                //Execute the Query
                $res=mysqli_query($conn, $sql);

                //Count Rows
                $count = mysqli_num_rows($res);

                //CHeck whether the foods are availalable or not
                if($count>0)
                {
                    //Foods Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the Values
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        ?>
                        
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    //CHeck whether image available or not
                                    if($image_name=="")
                                    {
                                        //Image not Available
                                        echo "<div class='error'>Image not Available.</div>";
                                    }
                                    else
                                    {
                                        //Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">Rs <?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <button class="btn btn-primary add-to-cart" onclick="addToCart('<?php echo $title ?>',<?php echo $price ?>, 1)">ADD+</button>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    //Food not Available
                    echo "<div class='error'>Food not found.</div>";
                }
            ?>

            

            

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->
    <script>
        
        function addToCart(name, price, quantity) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    console.log(xhr.responseText); // Log the response
                    if (xhr.status === 200) {
                        alert(xhr.responseText); // Show success message
                        updateButton(name, quantity); // Update button text
                    } else {
                        alert('Error adding item to cart');
                    }
                }
            };
            xhr.send("name=" + encodeURIComponent(name) + "&price=" + encodeURIComponent(price) + "&quantity=" + encodeURIComponent(quantity));
}


    function updateButton(name, quantity) {
        const addButton = document.querySelector(`button.add-to-cart[data-name='${name}']`);
        if (addButton) {
            if (quantity > 0) {
                addButton.innerHTML = `${quantity} <button class="btn btn-primary" onclick="addToCart('${name}','${price} , ${quantity + 1})">+</button> <button class="btn btn-primary" onclick="addToCart('${name}', '${price}', ${quantity - 1})">-</button>`;
            } else {
                addButton.disabled = true;
                addButton.innerHTML = "Out of stock";
            }
        }
    }

    
    </script>

    <?php include('partials-front/footer.php'); ?>