<?php

class Book {

    //Properties
    public $title;
    protected $author;
    private $price;

    // Constructor initialize title, author, and price
    public function __construct($title, $author, $price) {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }

    // Method to return the details of the book
    public function getDetails() {
        return "Title: {$this->title}, Author: {$this->author}, Price: \${$this->price}";
    }
    
    // Method to update the price of the book
    protected function setPrice($price) {
        $this->price = $price;
    }
    
    // Magic method to handle calls to non-existent methods
    public function __call($method, $arguments) {
        if ($method === 'updateStock') {
            echo "Stock updated for '{$this->title}' with arguments: " . implode(', ', $arguments) . "\n";
        } else {
            echo "Method {$method} does not exist.\n";
        }
    }
}

class Library {
    
  // Properties
  private $books = [];
  public $name;
  
  // Constructor to initialize the Library with name
  public function __construct($name) {
        $this->name = $name;
    }
    
  // Method to add a book to the library
  public function addBook(Book $book) {
        $this->books[] = $book;
    }

  // Method to remove a book from the library by title
  public function removeBook($title) {
      foreach ($this->books as $index => $book) {
          if ($book->title === $title) {
              unset($this->books[$index]);
              echo "Book '{$title}' removed from the library.\n";
              return;
          }
      }
      echo "Book '{$title}' not found in the library.\n";
  }

  // Method to list all books in the library
  public function listBooks($showHeader = true) {
        if ($showHeader) {
            echo "Books in the library:\n";
        }
        foreach ($this->books as $book) {
            echo $book->getDetails() . "\n";
        }
    }

  // Destructor to clean up the library
  public function __destruct() {
      echo "The Library '{$this->name}' is now closed.\n";
  }
}

// Implementation Tasks

// Create instances of Book and Library
$book1 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 12.99);
$book2 = new Book("1984", "George Orwell", 8.99);

$library = new Library("City Library");

// Adds books to the library
$library->addBook($book1);
$library->addBook($book2);

// Update price of a book
// Since the setPrice is protected, it will be ignored
// Use __call to demonstrate a non-existent method
$book1->updateStock(50); // Calls __call() for the updateStock method

// List all books in the library
$library->listBooks();

// Remove a book from the library
$library->removeBook("1984");

// List all books in the library after removal
echo "Books in the library after removal: \n";
$library->listBooks(false);

// Destroy the Library object to trigger the destructor
unset($library);

//Brief Explanation 
//To solve the problem, create two classes: Book and Library. The Book class features properties with different access levels (public, protected, private) to demonstrate encapsulation, including methods for getting details, updating the price, and handling undefined methods.
//The Library class manages a private array of books and a public name, with methods for adding, removing, and listing books, and includes a destructor to display a message upon object destruction.
