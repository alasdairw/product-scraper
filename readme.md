## Installation

Requirements: composer, PHP 5.4.

    git clone
    composer install

Running tests:

    phpunit

running the scraper 

    php artisan scrape:url

## General Notes/Assumptions made

I've used the Laravel Lumen framework for this.  Honestly, it's overkill, but it was a fast way to spin up
a scaffold to work in without a huge performance overhead, and in the event of this being real-world code, 
it's very likely that the system would need to do more with the data it's gathering - ship it to a database, 
cache it, republish it in some way - so while the framework is overkill for the specified task, it's likely 
to be more useful in a real world scenario where development would be ongoing.

The original application code is in app/Parsers, and app/Console/Commands/ScrapeCommand 

Tests are in /tests

There were a couple of points that were unclear.  They're mostly noted with @todo in the doc blocks, (along 
with occaisional notes for obvious next stages of the code if this were a real world exercise), but the major
point of confusion was the "description" field required by the JSON.  The human-visible test markup didn't contain 
content that looked like the content supplied JSON for the description (there was a section marked "description" 
but it was single-word, rather than the indicated sentence), so I opted to use the META tag description instead.

(If I hadn't been doing this over the bank holiday weekend, I'd have sought clarification.  I've annotated the
relevant function with a commented out version of the code required if I've picked the wrong content.)