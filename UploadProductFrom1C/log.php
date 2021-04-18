<?
//ВНИМАНИЕ!! в виде тестового задания сделал хранение логов в переменную. 
//  При использовании на боевом, перенести в файл ( или в БД. Если в БД, то проработать механизм периода хранения данных ) , чтобы избежать переполнение на сервере 
//  Так же в конструктор добавить очищение файла, чтобы не засорять систему.
class log {
    protected static $_instance;
    private $logAr ;

    private function __construct() {   
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;  
        }
 
        return self::$_instance;
    }
 
    private function __clone() {
    }

    private function __wakeup() {
    } 
    
    public static function setLog($data){
        $obj=self::$_instance;
        $obj->logAr[] = $data ;
    }

    public static function getLog(){
        $obj=self::$_instance;
        return $obj->logAr;
    }
}  
?>