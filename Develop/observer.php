<?php
/**
 * 观察者模式实例
 *
 * @package develop
 * @author Sphenginx
 **/

/**
 * 学生类
 *
 * @package develop
 * @author Sphenginx
 **/
class Student implements SplObserver
{
    protected $tipo = "Student";
    private $nome;
    private $endereco;
    private $telefone;
    private $email;
    private $_classes = array();
 
    public function GET_tipo() {
        return $this->tipo;
    }
 
    public function GET_nome() {
        return $this->nome;
    }
 
    public function GET_email() {
        return $this->email;
    }
 
    public function GET_telefone() {
        return $this->nome;
    }
 
    function __construct($nome) {
        $this->nome = $nome;
    }
 
    public function update(SplSubject $object){
        $object->SET_log("Comes from ".$this->nome.": I'm a student of ".$object->GET_materia());
    }
 
}
/**
 * 老师类
 *
 * @package develop
 * @author Sphenginx
 **/
class Teacher implements SplObserver
{
    protected $tipo = "Teacher";
    private $nome;
    private $endereco;
    private $telefone;
    private $email;
    private $_classes = array();
 
    public function GET_tipo() {
        return $this->tipo;
    }
 
    public function GET_nome() {
        return $this->nome;
    }
 
    public function GET_email() {
        return $this->email;
    }
 
    public function GET_telefone() {
        return $this->nome;
    }
 
    function __construct($nome) {
        $this->nome = $nome;
    }
 
    public function update(SplSubject $object){
        $object->SET_log("Comes from ".$this->nome.": I teach in ".$object->GET_materia());
    }
}
/**
 * 课程类
 *
 * @package develop
 * @author Sphenginx
 **/
class Subject implements SplSubject 
{
    private $nome_materia;
    private $_observadores = array();
    private $_log = array();
 
    public function GET_materia() {
        return $this->nome_materia;
    }
 
    function SET_log($valor) {
        $this->_log[] = $valor ;
    }
    function GET_log() {
        return $this->_log;
    }
 
    function __construct($nome) {
        $this->nome_materia = $nome;
        $this->_log[] = " Subject $nome was included";
    }
    /* Adiciona um observador */
    public function attach(SplObserver $classes) {
        $this->_classes[] = $classes;
        $this->_log[] = " The ".$classes->GET_tipo()." ".$classes->GET_nome()." was included";
    }
 
    /* Remove um observador */
    public function detach(SplObserver $classes) {
        foreach ($this->_classes as $key => $obj) {
            if ($obj == $classes) {
                unset($this->_classes[$key]);
                $this->_log[] = " The ".$classes->GET_tipo()." ".$classes->GET_nome()." was removed";
            }
        }
    }
 
    /* Notifica os observadores */
    public function notify(){
        foreach ($this->_classes as $classes) {
            $classes->update($this);
        }
    }
}

$subject = new Subject("Math");
$marcus = new Teacher("Marcus Brasizza");
$rafael = new Student("Rafael");
$vinicius = new Student("Vinicius");
 
// Include observers in the math Subject
$subject->attach($rafael);
$subject->attach($vinicius);
$subject->attach($marcus);
 
$subject2 = new Subject("English");
$renato = new Teacher("Renato");
$fabio = new Student("Fabio");
$tiago = new Student("tiago");
 
// Include observers in the english Subject
$subject2->attach($renato);
$subject2->attach($vinicius);
$subject2->attach($fabio);
$subject2->attach($tiago);
 
// Remove the instance "Rafael from subject"
$subject->detach($rafael);
 
// Notify both subjects
$subject->notify();
$subject2->notify();
 
echo "First Subject <br />";
echo "<pre>";
print_r($subject->GET_log());
echo "</pre>";
echo "<hr>";
echo "Second Subject <br />";
echo "<pre>";
print_r($subject2->GET_log());
echo "</pre>";