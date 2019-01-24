<?php

$this->blockStart("title");
echo $title;
$this->blockEnd("title");

$this->blockStart("body");
echo "Hello";
$this->blockEnd("body");

$this->extend("mainlayout");