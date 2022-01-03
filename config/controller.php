<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;

use React\EventLoop\Factory;

use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\Telegram\Methods\SendDocument;
use unreal4u\TelegramAPI\Telegram\Types\Custom\InputFile;
use unreal4u\TelegramAPI\TgLog;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use Dompdf\Dompdf;

class controller {

    //CONSTRUTOR
    public function __construct() {

        session_start();

        $this->iniSetConfigs();

    }

    //RENDER TEMPLATE TWIG
    public function loadViewTwig($view, $bind = array()){

        $load = new Twig_Loader_Filesystem("app/views");
        $twig = new Twig_Environment($load);

        $filter = new \Twig\TwigFilter("encode", function ($string) {
            return base64_encode($string);
        });

        $twig->addFilter($filter);

        $bind["server"]     = $_SERVER;
        $bind["session"]    = $_SESSION;
        $cookie             = array();

        array_walk($_COOKIE, function($value, $key) use(&$cookie){
            $cookie = array_merge($cookie, array($key => (in_array($key, array("MAIL", "PASS", "REME")) ? base64_decode($value) : $value)));
        });

        $bind["cookie"]     = $cookie;

        echo($twig->render("{$view}.twig", $bind));

    }

    //RENDER TEMPLATE TWIG AND RETURN OUT
    public function loadViewTwigOut($view, $bind = array()){

        $load = new Twig_Loader_Filesystem("app/views");

        $twig = new Twig_Environment($load);

        $bind["server"]     = $_SERVER;
        $bind["session"]    = $_SESSION;

        return $twig->render("{$view}.twig", $bind);

    }

    //REDIRECIONAR URL
    public function redirectRoute($route) {

		if(isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https") {

            header("Location: https://" . $_SERVER['HTTP_HOST'] . "{$route}");

		} else {

            header("Location: http://" . $_SERVER['HTTP_HOST'] . "{$route}");

        }

	}

	//PADRONIZACAO DE RETORNO JSON
    public function returnJson($data, $code = false, $message = false) {

        mb_internal_encoding("UTF-8");

        if ($code != false) {
            http_response_code($code);
        }

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        if ($message != false) {
            header("X-Erro: {$message}");
            header("Access-Control-Expose-Headers: X-Erro");
        }

        header("Content-Type: application/json");

        echo json_encode($data);

    }

    //FUNCAO PARA CAPTURAR O IP DO CLIENT
    public function getIpClient($ipCliente = "") {

        if (isset($_SERVER["REMOTE_ADDR"]) && $_SERVER["REMOTE_ADDR"] == "::1") {
            $ipCliente = "127.0.0.1";
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ipCliente = $_SERVER["HTTP_CLIENT_IP"];
        } else if (isset($_SERVER["REMOTE_ADDR"])) {
            $ipCliente = $_SERVER["REMOTE_ADDR"];
        } else {
            $ipCliente = "127.0.0.1";
        }

        return $ipCliente;

    }

    //GET DA MAIOR TAG DO GIT
    public function returnVersion(){

        $envVs = shell_exec("git describe");

        if(is_string($envVs)){
            $envVs = preg_replace("/-[a-zA-Z0-9]*/", "", $envVs);
        }

        return $envVs;

    }

    //IMPRIMIR OBJECTS
    public function viewObject($object = false){

        print("<pre>");
            var_dump($object);
        print("</pre>");

    }

    //IMPRIMIR OBJECTS E ENCERRAR SCRIPT
    public function viewObjectEnd($object = false){

        print("<pre>");
            var_dump($object);
        print("</pre>");

        exit();

    }

    //FUNCAO PARA ENVIAR EMAILS
    public function sendMail($email, $name, $subject, $body){
        try {

            $mail = new PHPMailer(true);

            $mail->SMTPDebug    = false;
            $mail->Host         = "smtp.gmail.com";
            $mail->SMTPAuth     = true;
            $mail->Username     = getenv("MAIL_NAME");
            $mail->Password     = getenv("MAIL_PASS");
            $mail->Port         = 587;
            $mail->CharSet      = "UTF-8";

            $mail->setFrom(getenv("MAIL_NAME"), "Notification");
            $mail->isSMTP();
            $mail->isHTML(true);

            $mail->addAddress($email, $name);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();

            return true ;

        } catch (Exception $e) {

            return false ;

        }
    }

    //FUNCAO DE TRADUCAO
    public function translate($word, $back = false){

        if($back == false){
            echo    (isset($_SESSION["translate"][$word])) ? $_SESSION["translate"][$word] : $word ;
        } else {
            return  (isset($_SESSION["translate"][$word])) ? $_SESSION["translate"][$word] : $word ;
        }

    }

    //DEFININDO DIRETIVAS DO PHP
    public function iniSetConfigs(){

        if(php_sapi_name() == "cli-server") {

            if(ini_set("display_errors", true) === false){
                error_log("FAIL INISET: DISPLAY_ERRORS");
            }

            if(ini_set("memory_limit", -1) === false){
                error_log("FAIL INISET: MEMORY_LIMIT");
            }

            if(ini_set("log_errors", true) === false){
                error_log("FAIL INISET: LOG_ERRORS");
            }

        }

    }

    //COMPACTANDO ARQUIVOS E FAZENDO O DOWNLOAD COM ZIP
    public function downZipFile($files = array()){

        $zip = new ZipArchive();

        if($zip->open("{$_SERVER["DOCUMENT_ROOT"]}/assets/files/compact.zip", ZipArchive::CREATE)  === true){

            foreach($files as $file){
                $zip->addFile("{$_SERVER["DOCUMENT_ROOT"]}/assets/files/{$file}", $file);
            }

            $zip->close();

            header("Content-type: application/zip");

            header("Content-disposition: attachment; filename='compact.zip'");

            readfile("{$_SERVER["DOCUMENT_ROOT"]}/assets/files/compact.zip");

            unlink("{$_SERVER["DOCUMENT_ROOT"]}/assets/files/compact.zip");

        }

    }

    //GERACAO DE QR-CODE
    public function genereteQrCode($data){

        $code       = new QrCode($data);
        $content    = $code->getContentType();

        header("Content-Type: {$content}");

        echo $code->writeString();

    }

    //UPLOAD CLOUDINARY
    public function uploadClodinary($file){

        \Cloudinary::config(array(
			"cloud_name" 	=> getenv("CLOUDINARY_CLOUD_NAME"),
			"api_key" 		=> getenv("CLOUDINARY_API_KEY"),
			"api_secret" 	=> getenv("CLOUDINARY_API_SECRET")
		));

        $response = \Cloudinary\Uploader::upload($file);

        return $response["secure_url"];

    }

    //TRANSFORMA O FORMATO (DD/MM/AAAA HH:MM) PARA (AAAA-MM-DD HH:MM:SS)
	public function formatDate($data){

		$data = str_replace(" ", "/", $data);
		$data = str_replace(":", "/", $data);
		$data = explode("/", $data);
		$data = $data[2]."-".$data[1]."-".$data[0]." ".$data[3].":".$data[4].":00";
		$data = date("Y-m-d H:i:s", strtotime($data));

        return $data;

	}

	//CALCULA A PROXIMIDADE DE UM PONTO A OUTRO NO GLOBO EM KM
	public function calcProximidadeKM($latitudeuser, $longitudeuser, $latitudelocal, $longitudelocal){

		return round(6371 * acos(
			cos(deg2rad($latitudeuser))
			* cos(deg2rad($latitudelocal))
			* cos(deg2rad($longitudelocal) - deg2rad($longitudeuser))
			+ sin(deg2rad($latitudeuser))
			* sin(deg2rad($latitudelocal))
			)
		);

	}

    //FUNCTION PARA REGISTRO LOCAL DE LOGS
    public function registryLogs($log){

        error_log("[".date("Y-m-d H:i:s")."] - {$log}".PHP_EOL, 3, "./error.log");

    }

    //ENVIANDO MESSAGENS VIA TELEGRAM
    public function sendTelegramMessage($group_id, $message){

        $loop   = Factory::create();
        $tglog  = new TgLog(getenv("TELEGRAM_BOT_TOKEN"), new HttpClientRequestHandler($loop));

        $sendMessage                = new SendMessage();
        $sendMessage->parse_mode    = "markdown";
        $sendMessage->chat_id       = $group_id;
        $sendMessage->text          = $message;

        $promise = $tglog->performApiRequest($sendMessage);

        $promise->then(

            function ($response) {
                $this->viewObject($response);
            },

            function (\Exception $exception) {
                echo("Exception ".get_class($exception)." caught, message: ".$exception->getMessage());
            }

        );

        $loop->run();

    }

    //ENVIANDO ARQUIVOS VIA TELEGRAM
    public function sendTelegramFile($group_id, $document, $message){

        $loop   = Factory::create();
        $tglog  = new TgLog(getenv("TELEGRAM_BOT_TOKEN"), new HttpClientRequestHandler($loop));

        $sendDocument           = new SendDocument();
        $sendDocument->caption  = $message;
        $sendDocument->chat_id  = $group_id;
        $sendDocument->document = new InputFile($document);

        $promise = $tglog->performApiRequest($sendDocument);

        $promise->then(

            function ($response) {
                $this->viewObject($response);
            },

            function (\Exception $exception) {
                echo("Exception ".get_class($exception)." caught, message: ".$exception->getMessage());
            }

        );

        $loop->run();

    }

    //GERADOR DE PDF
    public function generatorPdf($html = "", $filename = "docs"){

        //INSTANCIANDO O DOMPDF
        $dompdf = new Dompdf();

        //INSERINDO O HTML QUE QUEREMOS CONVERTER
        $dompdf->loadHtml($html);

        //DEFININDO O PAPEL E A ORIENTAÇÃO
        $dompdf->setPaper("A4", "portrait");

        //RENDERIZANDO O HTML COMO PDF
        $dompdf->render();

        //ENVIANDO O PDF PARA O BROWSER
        $dompdf->stream("{$filename}.pdf");

    }

    //CRIANDO PLANILHA XLSX
    public function generatorXlsx($data = array(), $filename = "docs"){

        //CREATES NEW SPREADSHEET
        $spreadsheet = new Spreadsheet();

        //SIZE FIST NAME
        $sizehead = count($data);

        //RETRIEVE THE CURRENT ACTIVE WORKSHEET
        $spreadsheet->getActiveSheet()->fromArray($data, NULL, "A1");

        //DETERMINANDO FONT
        $spreadsheet->getDefaultStyle()->getFont()->setName("Calibri");

        //DETERMINANDO SIZE FONT
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

        //FREEZE FIRST ROW
        $spreadsheet->getActiveSheet()->freezePane("A2");

        //INTERANDO COLUNAS ATIVAS DA LINHA 1
        foreach (range("A", $spreadsheet->getActiveSheet()->getHighestDataColumn()) as $cell) {

            //SET AUTOSIZE
            $spreadsheet->getActiveSheet()->getColumnDimension($cell)->setAutoSize(true);

            //NEGRITO PRIMEIRA LINHA DA PLANILHA
            $spreadsheet->getActiveSheet()->getStyle("{$cell}1")->getFont()->setBold(true);

            //STYLE COLOR
            $spreadsheet->getActiveSheet()->getStyle("{$cell}1")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB("D8DBDCD1");

        }

        //PASSANDO POR TODAS AS CELULAS ATIVAS
        foreach (range(1, $sizehead) as $row) {

            foreach (range("A", $spreadsheet->getActiveSheet()->getHighestDataColumn()) as $colunm) {

                //SET ALIGNMENT HORIZONTAL
                $spreadsheet->getActiveSheet()->getStyle("{$colunm}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                //SET ALIGNMENT VERTICAL
                $spreadsheet->getActiveSheet()->getStyle("{$colunm}{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                //SET BORDERS IN CELLS
                $spreadsheet->getActiveSheet()->getStyle("{$colunm}{$row}")->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle("{$colunm}{$row}")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle("{$colunm}{$row}")->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle("{$colunm}{$row}")->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);

            }

        }

        //CONTROLES DO MERGE CELL
        $datamerge = "";
        $rowsmerge = 1;

        //PASSANDO POR TODAS AS CELULAS ATIVAS
        foreach (range(1, $sizehead) as $row) {

            //FAZENDO MERGE LINHAS IRMAS COM A PRIMEIRA COLUNA COM VALORES IGUAIS
            if($spreadsheet->getActiveSheet()->getCell("A{$row}")->getValue() != $datamerge){

                if(($row - 1) < $rowsmerge){
                    $row++;
                }

                //MERGE CELLS ANTERIORES
                $spreadsheet->getActiveSheet()->mergeCells("A".($rowsmerge).":A".($row - 1));

                //DADOS DE CONTROLE
                $datamerge = $spreadsheet->getActiveSheet()->getCell("A{$row}")->getValue();
                $rowsmerge = $row;

            }

            //MERGE PARA ULTIMAS LINHAS
            if($row == $sizehead){

                //MERGE CELLS ANTERIORES
                $spreadsheet->getActiveSheet()->mergeCells("A".($rowsmerge).":A".($row));

            }

        }

        //WRITE AN .XLSX FILE
        $writer = new Xlsx($spreadsheet);

        //SAVE .XLSX FILE TO THE CURRENT DIRECTORY
        //$writer->save("{$filename}.xlsx");

        //DEINIFNDO CABECALHOS
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename={$filename}.xlsx");
        header("Cache-Control: max-age=0");

        //OUT DOWNLOAD
        $writer->save("php://output");

    }

}
