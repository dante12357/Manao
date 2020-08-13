<?php
header('content-type: text/html; charset=utf-8;');

class CustomerController extends AbstractController
{
    protected $conn;
    private $xml;

    public function __construct()
    {
        $this->xml = new \DOMDocument('1.0', "UTF");
        $this->xml->load("users.xml");
    }

    public function generateSalt()
    {
        $salt = '';
        $saltLength = 8;
        for ($i = 0; $i < $saltLength; $i++) {
            $salt .= chr(mt_rand(33, 126));
        }
        return $salt;
    }

    public function loginAction()
    {
        if ($_POST) {
            $errors = array();
            if ($_POST['login'] == '') {
                $errors[] = "<div>Login cannot be empty!</div>";
            }
            if ($_POST['password'] == '') {
                $errors[] = "<div>Password cannot be empty!</div>";
            }
            if (empty($errors)) {
                $xsl = new \SimpleXMLElement($this->xml->saveXML());
                $result = $xsl->xpath('//users/user/login[.="' . $_POST['login'] . '"]/parent::*');
                $result = json_decode(json_encode($result[0]), true);

                if (!empty($result)) {
                    $salt = $result['salt'];

                    $saltedPassword = md5($_POST['password'] . $salt);

                    if ($result['password'] == $saltedPassword) {
                        $_SESSION['auth'] = true;
                        $_SESSION['login'] = $result['login'];
                        $_SESSION['name'] = $result['name'];

                        header('Content-Type: application/json');
                        echo json_encode(array('success' => 1,
                            "action" => "redirect",
                            "redirectUrl" => "/customer/login"));
                        exit;
                    } else {
                        header('Content-Type: application/json');
                        echo json_encode(array('success' => 0,
                            'message' => "Incorrect login or password"));
                        exit;
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(array('success' => 0,
                        'message' => "Incorrect login or password"));
                    exit;
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(array('success' => 0,
                    'message' => $errors));
                exit;
            }
        }
        $this->render('login');

    }

    public function registrationAction()
    {

        if ($_POST) {
            $errors = array();
            if ($_POST['login'] == '') {
                $errors[] = "<div>Login cannot be empty!</div>";
            }
            if ($_POST['password'] == '') {
                $errors[] = "<div>Password cannot be empty!</div>";
            }
            if ($_POST['email'] == '') {
                $errors[] = "<div>Email cannot be empty!</div>";
            }
            if ($_POST['name'] == '') {
                $errors[] = "<div>Name cannot be empty!</div>";
            }
            if ($_POST['password'] !== $_POST['confirm_password']) {
                $errors[] = "<div>Password mismatch!</div>";
            }
            if (strlen($_POST['password']) < 6) {
                $errors[] = "<div>Password must be at least 6 characters!</div>";
            }

            $salt = $this->generateSalt();
            $saltedPassword = md5($_POST['password'] . $salt);

            $rootTag = $this->xml->getElementsByTagName("users")->item(0);
            $xsl = new \SimpleXMLElement($this->xml->saveXML());
            $result_login = $xsl->xpath('//users/user/login[.="' . $_POST['login'] . '"]/parent::*');
            $result_email = $xsl->xpath('//users/user/email[.="' . $_POST['email'] . '"]/parent::*');

            if (!empty($result_login)) {
                $errors[] = "<div>User exists!</div>";
            }
            if (!empty($result_email)) {
                $errors[] = "<div>Email exists!</div>";
            }

            if (empty($errors)) {

                $dataTag = $this->xml->createElement("user");
                $loginTag = $this->xml->createElement("login", $_POST['login']);
                $passwordTag = $this->xml->createElement("password", $saltedPassword);
                $emailTag = $this->xml->createElement("email", $_POST['email']);
                $nameTag = $this->xml->createElement("name", $_POST['name']);
                $saltTag = $this->xml->createElement("salt", $salt);

                $dataTag->appendChild($loginTag);
                $dataTag->appendChild($passwordTag);
                $dataTag->appendChild($emailTag);
                $dataTag->appendChild($nameTag);
                $dataTag->appendChild($saltTag);
                $rootTag->appendChild($dataTag);

                $this->xml->save("users.xml");

                header('Content-Type: application/json');
                echo json_encode(array('success' => 1,
                    'message' => "<div>You are registered successfully!</div>"));
                exit;
            } else {

                header('Content-Type: application/json');
                echo json_encode(array('success' => 0,
                    'message' => $errors));
                exit;
            }
        }
        $this->render('registration');
    }
}
