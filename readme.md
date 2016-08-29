## Installation

Requirements: composer, PHP 5.4.

    git clone
    composer install

Running tests:

    phpunit

running the scraper 

    php run_generate_json.php

## General Notes

I started out doing this using the Lumen framework.  I had it more or less done (correct output/tests passing), when 
I realised that the framework was total overkill, so I refactored it completely.  I took the oppotunity of a second 
pass to better separate things, and to properly mock my tests.

There's still one test that isn't quite mocked to my satisfaction, and winds up making an external http call that's 
not really needed, but I hope one test that's not perfect is forgiveable - I thought the alternative method to solve
the problem was overkill.

Tests are in /tests

There were a couple of points that were unclear.  They're mostly noted with @todo in the doc blocks, (along 
with occaisional notes for obvious next stages of the code if this were a real world exercise), but the major
point of confusion was the "description" field required by the JSON.  The human-visible test markup didn't contain 
content that looked like the content supplied JSON for the description (there was a section marked "description" 
but it was single-word, rather than the indicated sentence), so I opted to use the META tag description instead.

(If I hadn't been doing this over the bank holiday weekend, I'd have sought clarification.  I've annotated the
relevant function with a commented out version of the code required if I've picked the wrong content.)