
    <form action="add-new-product.php" method="POST" enctype="multipart/form-data">
        <label for="product-name">Product Name</label>
        <input type="text" name="product-name" id="productName">

        <label for="type">Type:</label>
        <select name="product-type" id="guitarType">
            <option value="electric">Electric</option>
            <option value="acoustic">Acoustic</option>
        </select>

        <label for="product-name">Product Description</label>
        <input type="text" name="product-desc" id="productDesc">

        <label for="product-price">Product Price</label>
        <input type="text" name="product-price" id="productPrice">

        <label for="product-image">Product Image</label>
        <input type="file" name="product-image" id="productImg">

        <label for="color">Color</label>
        <select name="guitar-color" id="guitarColor">
            <option value="white">White</option>
            <option value="black">Black</option>
            <option value="green">Green</option>
            <option value="blue">Blue</option>
            <option value="red">Red</option>
            <option value="yellow">Yellow</option>
        </select>
       
        <button type="submit" name="submit" id="submitBtn">Add</button>
    </form>

