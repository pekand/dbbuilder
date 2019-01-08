<?php

$this->blockStart("title");
echo $title;
$this->blockEnd("title");

$this->blockStart("body");
echo "hello";
$this->blockEnd("body");

$this->extend("layout");