<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rest API</title>
</head>
<style>
    th,
    td {
        height: 50px;
        width: 150px;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>

<body>
    <h1>
        Create Product
    </h1>

    <?php
    $id = $name = $price = $quantity = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = input_data($_POST["id"]);
        $name = input_data($_POST["name"]);
        $price = input_data($_POST["price"]);
        $quantity = input_data($_POST["quantity"]);
    }

    function input_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function post_data($url, $id, $name, $price, $quantity)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\t\"id\":\"$id\",\n\t\"name\":\"$name\",\n\t\"price\":\"$price\",\n\t\"quantity\":\"$quantity\"}",
            CURLOPT_HTTPHEADER => array(
                "Content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function get_data($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HEADER => array(
                "Content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <pre>ID
            <input type="text" required="required" name="id" value=""><br>
        </pre>
        <pre>Name
            <input type="text" required="required" name="name" value=""><br>
        </pre>
        <pre>Price
            <input type="text" required="required" name="price" value=""><br>
        </pre>
        <pre>Quantity
            <input type="text" required="required" name="quantity" value=""><br>
        </pre>

        <input type="submit" name="button" value="Submit"><br>
    </form>

    <?php
    if (isset($_post['button'])) {
        $data = post_data("http://127.0.0.1:5010/create_product", $id, $name, $price, $quantity);
        echo "<br>Data berhasil dikirim<br>";
    }
    ?>

    <h1>
        Daftar Siswa
    </h1>

    <?php
    $dataProduct = get_data("http://127.0.0.1:5010/get_product");
    $obj = json_decode($dataProduct, true);
    echo '<table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </table>';
    foreach($obj as $item) {
        $id = $item["id"];
        $name = $item["name"];
        $price = $item["item"];
        $quantity = $item["quantity"];
        echo '<table>
                    <tr>
                        <td>' . $id . '</td>
                        <td>' . $name . '</td>
                        <td>' . $price . '</td>
                        <td>' . $quantity . '</td>
                    </tr>
                </table>';
    }
    ?>
</body>

</html>