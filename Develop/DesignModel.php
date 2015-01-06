<?php
//1、 工厂模式 factory.php
class Automobile
{
    private $vehicle_make;
    private $vehicle_model;
 
    public function __construct($make, $model)
    {
        $this->vehicle_make = $make;
        $this->vehicle_model = $model;
    }
 
    public function get_make_and_model()
    {
        return $this->vehicle_make . ' ' . $this->vehicle_model;
    }
}

class AutomobileFactory
{
    public static function create($make, $model)
    {
        return new Automobile($make, $model);
    }
}

// have the factory create the Automobile object
$veyron = AutomobileFactory::create('Bugatti', 'Veyron');

var_dump($veyron->get_make_and_model()); // outputs "Bugatti Veyron"

//2、 单例模式 singleton.php
class Singleton
{
    /**
     * Returns the *Singleton* instance of this class.
     *
     * @staticvar Singleton $instance The *Singleton* instances of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new self();
        }
 
        return $instance;
    }
 
    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct(){}
 
    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone(){}
 
    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup(){}
}
 
$obj = Singleton::getInstance();
var_dump($obj === Singleton::getInstance());             // bool(true)
 
//3、 观察者模式 observer.php
/**
 * 观察者
 */
class observer implements SplObserver
{
    static private $object;
 
    public function __construct()
    {
 
    }
 
    public function update(SplSubject $subject, $args = '')
    {
        $event = $subject->event;
        $object = new execute();
 
        if(method_exists($object, $event)) {
            $object->$event($args);
        }
    }
}
 
// 主题
class subject implements SplSubject
{
    public $event;
 
    public $_observers;
 
    public function __construct()
    {
        if($this instanceof SplSubject) {
            $this->_observers = new SplObjectStorage();
            $this->attach(new observer());
        }
    }
 
    public function attach(SplObserver $observer)
    {
        $this->_observers->attach($observer);
        // $this->_observers[] = $observer;
    }
 
    public function detach(SplObserver $observer)
    {
        $this->_observers->detach($observer);
        // if($index = array_search($observer, $this->_observers, true)) {
        //     unset($this->_observers[$index]);
        // }
    }
 
    public function notify($args = '')
    {
        foreach($this->_observers as $observer) {
            $observer->update($this, $args);
        }
    }
}

class execute
{
    public function say_hello($args = '')
    {
        echo "hello", $args;
    }
}

$subject = new subject();
$subject->event = 'say_hello';
$subject->notify(', world!');
 

// 4、策略模式 strategy.php
// 策略抽象 Strategy
interface OutputInterface
{
    public function load($output);
}

// 策略实现 ConcreteStrategy
class SerializedArrayOutput implements OutputInterface
{
    public function load($output)
    {
        return serialize($output);
    }
}
 
class JsonStringOutput implements OutputInterface
{
    public function load($output)
    {
        return json_encode($output);
    }
}

class ArrayOutput implements OutputInterface
{
    public function load($output)
    {
        return $output;
    }
}

// 应用场景 Context
class SomeClient
{
    private $output;
 
    public function setOutput(OutputInterface $outputType)
    {
        $this->output = $outputType;
    }
 
    public function loadOutput($output)
    {
        return $this->output->load($output);
    }
}

$client = new SomeClient();
$initData = array('hello' => 'world');


// Want some JSON?
$client->setOutput(new JsonStringOutput());
$jsonStringData = $client->loadOutput($initData);
echo($jsonStringData);


// Want some Serialized?
$client->setOutput(new SerializedArrayOutput());
$serializedArrayData = $client->loadOutput($initData);
var_dump($serializedArrayData);


// 观察者模式 observer2.php

class Observable implements SplSubject
{
    private $storage;
 
    function __construct()
    {
        $this->storage = new SplObjectStorage();
    }
 
    function attach(SplObserver $observer)
    {
        $this->storage->attach($observer);
    }
 
    function detach(SplObserver $observer)
    {
        $this->storage->detach($observer);
    }
 
    function notify()
    {
        foreach ($this->storage as $obj) {
            $obj->update($this);
        }
    }
}
 
abstract class Observer implements SplObserver
{
    private $observable;
 
    function __construct(Observable $observable)
    {
        $this->observable = $observable;
        $observable->attach($this);
    }
 
    function update(SplSubject $subject)
    {
        if ($subject === $this->observable) {
            $this->doUpdate($subject);
        }
    }
 
    abstract function doUpdate(Observable $observable);
}
 
class ConcreteObserver extends Observer
{
    function doUpdate(Observable $observable)
    {
        echo 'ConcreteObserver', '<br>';
    }
}
 
class ConcreteObserver2 extends Observer
{
    function doUpdate(Observable $observable)
    {
        echo 'ConcreteObserver2', '<br>';
    }
}
 
$observable = new Observable();
new ConcreteObserver($observable);
new ConcreteObserver2($observable);
$observable->notify();
