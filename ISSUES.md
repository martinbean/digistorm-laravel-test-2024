# Issues

## Deficiencies
- Saving of related data (i.e. contacts and associated phone numbers) were done in separate queries. I wrapped these instances up into database transactions, so they either succeed or fail as a whole, and to prevent leaving the database in an undesirable state (i.e. where a contact has been saved but then there was a problem saving an associated phone number).
- Even though there is now validation in place, I’m not a fan of blindly unguarding all columns in Eloquent models, and prefer to explicitly list columns I expect to be fillable. I then use `$request->validated()` or `$request->safe()` to then only pass values that have been explicitly validated to any mass assignment-related methods on models.

## Improvements
- Phone number saving is a bit flaky. Humans aren’t good at entering phone numbers in E.164 format; they’ll naturally use punctuation like spaces, brackets for area codes, omit the country code, etc. With more time, I’d use some sort of web service like [the Twilio Lookup API][1] to parse a human-entered phone number into its E.164 equivalent.
- Small improvements to the database scheme could be made.
    - `first_name` and `last_name` could be renamed to `given_name` and `family_name` to make it more localizable (https://www.kalzumeus.com/2010/06/17/falsehoods-programmers-believe-about-names/ would be pertinent).
    - I’d have personally named the date of birth column something like `birth_date` instead of the all-uppercase `DOB` it is now.
- I added a Fulltext index to the `contacts` table to facilitate searching over the first name, last name, and company name fields. This would be something to keep an eye on, especially if the database were to grow in number of records significantly. If it did, it may be worth evaluating other solutions, such as [Elasticsearch][2].

## Potential security issues
- Biggest issue is application has no authentication or authorisation. Any one with the URL can search, create, update, and delete contacts at will.

[1]: https://www.twilio.com/docs/lookup/v2-api
[2]: https://www.elastic.co/elasticsearch
