<?php 

# COMANDOS PARA COLOCAR O JOB MASTER NA CRON DO SERVIDOR

# WRITE OUT CURRENT CRONTAB
# crontab -l > phpcron

# ECHO NEW CRON INTO CRON FILE
# echo "* * * * * cd /path/project/core && php -f cron.php 1>> /dev/null 2>&1" >> phpcron

# INSTALL NEW CRON FILE
# crontab phpcron
# rm phpcron

//UTILIZACAO DO COMPOSER
if(file_exists("{$_SERVER["DOCUMENT_ROOT"]}/vendor/autoload.php")){
    require("{$_SERVER["DOCUMENT_ROOT"]}/vendor/autoload.php");
}

//CREATE A NEW INSTANCE OF JOBBY
$jobby = new Jobby\Jobby();

//ADD COMAND
$jobby->add("jobone", [

    //RUN A SHELL COMMAND
    "command"  => "ls",

    //AGENDAND EXECUCAO DO COMANDO
    "schedule" => "0 * * * *",

    //DESABILITANDO COMMANDO
    "enabled"  => false,

    //CASO COMAND NÃO SEJA UTILIZADO
    // "closure"  => function() {
    //     echo "I'm a function!\n";
    //     return true;
    // },

    //ESSA LIB OFERECE CONFIGURACAO DO ENVIO DE EMAIL CASO A ROTINA NAO TENHA SIDO EXECUTADA COM SUCESSO
    //MAIS INFORMCACOES EM https://github.com/jobbyphp/jobby

]);

//EXECUTE COMMANDS
$jobby->run();