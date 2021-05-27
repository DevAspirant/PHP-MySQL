<!-- هذا الملف يستخدم لتطبيق مبدأ البرمجة الشيئية لعرض الخدمات-->
<?php 

class Service{

    // المتغيرات داخل الكلاس تسمى بروبرتى 
    public $available;
    public $taxRate;
    protected $type;
    private $price;

    // constructor بناء
    public function __construct()
    {
        //echo "This class has been '".__CLASS__."' has started";
        $this->available = true;
        $this->taxRate = 0;
    }

    // destructors :  هدم الوبجيكيت و الكلاس
    public function __destruct()
    {
        //echo "This class has been '".__CLASS__."' has desructed";
    }

    // الدوال داخل الكلاس تسمى ميثود
    public function all(){
        return [
            ['name'=>'consultation','price'=>500,'days'=>['Sun','Mon']],
            ['name'=>'development','price'=>1000,'days'=>['Sun','Mon']],
            ['name'=>'consultation','price'=>500,'days'=>['Sun','Mon']],
        ];
    }

    // حساب الضريبة
    public function price($price){
        if($this->taxRate > 0){
            return $price + ($price * $this->taxRate);
        }
        return $price;
    } 
}