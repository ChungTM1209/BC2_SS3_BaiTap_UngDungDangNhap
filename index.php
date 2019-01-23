<?php
function loadRegistration($fileName)
{
    $jsonData = file_get_contents($fileName);
    $arr_data = json_decode($jsonData, true);
    return $arr_data;
}

function saveDataJson($fileName, $name, $email, $phoneNum)
{
    try {
        $contact = array(
            'name' => $name,
            'email' => $email,
            'phoneNum' => $phoneNum
        );
        $arr_data = loadRegistration($fileName);
        array_push($arr_data, $contact);
        $jsonData = json_encode($arr_data, JSON_PRETTY_PRINT);
        file_put_contents($fileName, $jsonData);
        echo "Luu du lieu thanh cong";

    } catch (Exception $e) {
        echo "Loi", $e->getMessage(), "\n";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phoneNum = $_POST["phoneNum"];
    $error = false;
    if (empty($name)) {
        $error = true;
        $nameError .= "Tên đăng nhập không được để trống.";
    }
    if (empty($email)) {
        $error = true;
        $emailError .= "Tên email không được để trống.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError .= "Tên email phải là: xxx@xxx.xxx.xxx";
    }
    if (empty($phoneNum)) {
        $error = true;
        $phoneNumError .= "Số điện thoại không được để trống.";
    }
    if ($error == false) {
        saveDataJson('data.json', $name, $email, $phoneNum);
        $name = null;
        $email = null;
        $phoneNum = null;
    }
}
?>
<form method="post">
    <h1>Registration Form</h1>
    <fieldset>
        <legend>Detail</legend>
        <div>
            <p class="register">User Name: </p>
            <input type="text" name="name"> <?php echo $nameError; ?> <br>
            <p class="register">Email:</p>
            <input type="text" name="email"><?php echo $emailError; ?><br>
            <p class="register">Phone number:</p>
            <input type="text" name="phoneNum"><?php echo $phoneNumError; ?><br>
            <input type="submit">
        </div>
    </fieldset>

<?php
$registrations = loadRegistrations('data.json');
?>
<h2>Registration list</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
    </tr>
    <?php foreach ($registrations as $registration): ?>
        <tr>
            <td><?= $registration['name']; ?></td>
            <td><?= $registration['email']; ?></td>
            <td><?= $registration['phone']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</form>