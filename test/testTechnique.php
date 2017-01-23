<?php

/*

//---------------------------------------------
Quels fonctions sont en rapport avec les dossiers?

opendir, readdir, getcwd

//---------------------------------------------

Quel est l'affichage de ce script?

*/
class A {
    private $a = 1;
    public function __construct ($a)
    {
        $this->a = $a;
    }
}

class B extends A {
    private $a;
    public function getB()
    {
        return $this->a;
    }
}

$b = new B(1);
echo $b->getB();

//RIEN

//---------------------------------------------

//Choisissez la ou les bonnes réponses:
class M {
    function __destruct()
    {
        echo 'destruction';
    }
}

$class = "M";
$my = new $class;

//Destruction

//---------------------------------------------

//What is the output of the following script?

function foo(&$a = 8)
{
    $b = &$a;
    $b -= $a +3;
    return $b;
}

$a = foo(4);
echo $a;

//PHP Error

//---------------------------------------------

// Observez le code suivant qui a pour but d'assurer un numéro de compte valide:

$accountNr = 0;
if(isset($_GET['accountNr'])) {
    $accountNr = $_GET['accountNr'];
}

echo empty($accountNr) ?
echo 'le numéro fourni est invalide' :
echo 'votre numéro a bien été enregistré';

//Quels probleme avec ce code?

// Le test de validité de $accountNr est incorrect

//---------------------------------------------

//Parmi les affirmations suiantes concernant la fonction require_once, lesquelles sont vraies en PHP5?

// Require ne verifie pas la présence du fichier contrairement à require_once

//---------------------------------------------

// Afin de pouvoir récupérer les données envoyées par un formulaire HTML en utilisant un parametrage dans l'url, on peut utiliser :

//$_GET

//---------------------------------------------

// Que doir retourner la fonction __sleep() pour que ce script affiche 'hello world' ?

class MagicMCQ {
    public $name;
    public $nickname;
    public $greeting;

    function __construct($name, $nickname)
    {
        $this->name = $name;
        $this->nickname = $nickname;
        $this->constructGreetings();
    }

    function constructGreetings()
    {
        $this->greetings = "{$this->name} {$this->nickname}";
    }

    function sayHello()
    {
        echo $this->greetings;
    }

    function __sleep()
    {
        //Missing return statement
    }

    function __wakeup()
    {
        $this->constructGreetings();
    }
}

$var = new MagicMCQ("hello", "World");
$var = serialize($var);
$var = unserialize($var);
$var->sayHello();

// return ['name', 'nickname'];

//---------------------------------------------

// Quels fonctions sont en rapport avec la manipulation des chaines de caractère?

// explode, levenshtein, str_pad,

//---------------------------------------------

// En PHP 5.3, quels sont les types de code qui peuvent être affectés par des espaces de noms?

//Les classes, les interfaces

//---------------------------------------------

//What is  the most important trait of polymorphism?

// The common interface

//---------------------------------------------

// Which functions can help securing data input?

//strip_tags, htmlentities, htmlspecialchars, html_entity_decode

//---------------------------------------------

// Afin de pouvoir utiliser l'espace de stockage $_SESSION, il faut d'abord:

// Faire un appel session_start() avant toute autre opération

//---------------------------------------------

// En PHP 5.4, quelles sont les affirmations quivantes qui sont justes?

// Une classe définie comme abstraites ne peut etre instanciée
// Une méthode abstraite force la classe elle-meme a étre abstraite.


//---------------------------------------------

//Quel sera l'affichage de ce script?

try {
    $tab = [1,2,3]%[2,1,0];
    if($tab == false) {
        throw new Exception("Illegal operation");

    }
} catch (Exception $e) {
    echo $e->getMessage();
} finally {
    var_dump($tab);
}

// Illegal operation int(0)

//---------------------------------------------

// Quelles sont les affirmations suivantes qui sont justes?

//Phar est une extenssion qui permet de fournir et executer une application complete PHP depuis un seul fichier
//PDO est une interface d'abstraction


//---------------------------------------------

// Quelles affirmations sont éxactent?

// Php convertit automatiquement les variables dans les types souhaités par les opérateurs
// La conversion de 10 petit chaton en entier donne 10


//---------------------------------------------

//You need to delegate parts of your web hosting to another person. Although you will not be able to control the hosted code, how could you protect your server.
// activate safe_mode (dépréciée), disable enable_dl (deprécié), use disable_functions

//---------------------------------------------

//Quelles sont les affirmations suivantes qui sont justes?

// Une interface peut uniquement définir des méthodes publics.
// Une classe peut implémenter plusieur interface.

//---------------------------------------------

//What does the following script output.

$a = array("foo" => "bar", array("foobar" => "baz"));
echo count($a, true);

//3

//---------------------------------------------

// Quelles sont les affirmations suivantes qui sont justes?

//La méthode __toString() détermine comment l'objet doit réagir lorsqu'il est traité comme une chaîne de caractères
// __set() est sollicitée lors de l'écriture de données vers des propriétés inaccessibles.
// __isset() est sollicitée lorsque isset() ou la fonction empty() sont appelées sur des propriétés inaccessibles.

//---------------------------------------------

//Supposing that the session started correctly, how can the id for the current session can be obtained.

//By using session_id(), Via SID,

//---------------------------------------------

// Which instruction is not linked to the switch statement?

// continue

//---------------------------------------------



//---------------------------------------------

//---------------------------------------------

//---------------------------------------------

//---------------------------------------------

//---------------------------------------------

//---------------------------------------------

//---------------------------------------------

//---------------------------------------------

 ?>
