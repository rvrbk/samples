<?php

/**
 * @author Rik Verbeek
 * @since 2021-03-21
 * 
 * Bookshelf to hold various types of media. The assignment was to make a bookshelf class where different types of items could be added and retrieved
 */
class Bookshelf 
{
    private $capacity;
    private $items = [];

    function __construct(int $capacity)
    {
        $this->capacity = $capacity;
    }

    // Store an item of media
    public function store(Media $item) 
    {
        // If the shelf is at capacity throw an exception
        if($this->getAvailability() === 0) {
            throw new Exception('AT CAPACITY');
        }

        // Add the item if it not already exists
        if(!key_exists($item->getKey(), $this->items)) {
            $this->items[$item->getKey()] = $item;
        }
    }

    public function retrieve(String $key)
    {
        // If item is available return it 
        if($item = $this->items[$key]) {
            unset($this->items[$key]);
            
            return $item;
        }

        return false;
    }

    public function getCapacity() : int
    {
        return $this->capacity;
    }

    // How many items are in on the shelf
    public function getCount() : int
    {
        return count($this->items);
    }

    // How many more items can be stored
    public function getAvailability() : int
    {
        return $this->getCapacity() - $this->getCount();
    }
}

/**
 * @author Rik Verbeek
 * @since 2021-03-21
 * 
 * Media class 
 */
class Media 
{
    private $content = [];

    function __construct(Array $content)
    {
        $this->content = $content;
    }

    public function getPage(int $pagenumber)
    {
        if(key_exists($pagenumber, $this->content)) {
            return $this->content[$pagenumber];
        }

        return false;
    }
}

/**
 * @author Rik Verbeek
 * @since 2021-03-21
 * 
 * Book class 
 */
class Book extends Media
{
    private $author;
    private $title;

    function __construct(String $author, String $title, Array $content)
    {
        parent::__construct($content);

        $this->author = $author;
        $this->title = $title;
    }

    public function getKey() : String
    {
        return $this->author . $this->title;
    }
}

/**
 * @author Rik Verbeek
 * @since 2021-03-21
 * 
 * Magazine class 
 */
class Magazine extends Media
{
    private $name;

    function __construct(String $name, Array $content)
    {
        parent::__construct($content);

        $this->name = $name;
    }

    public function getKey() : String
    {
        return $this->name;
    }
}

/**
 * @author Rik Verbeek
 * @since 2021-03-21
 * 
 * Notebook class 
 */
class Notebook extends Media
{
    private $owner;

    function __construct(String $owner, Array $content)
    {
        parent::__construct($content);

        $this->owner = $owner;
    }

    public function getKey() : String
    {
        return $this->owner;
    }
}