# grammar [an online sentence generator]

This project stores various grammars in a simplified version of **[Backus-Naur Form (BNF)](https://en.wikipedia.org/wiki/Backus–Naur_form)**; it is built in PHP and hosted publicly on [my UW student server](https://students.washington.edu/bcolberg/grammar/).

#### How can I use it?
Simply go to [my website](https://students.washington.edu/bcolberg/grammar/), select a grammar (English or Math, currently), select an identifier in that grammar, and click the *Generate* button! It'll output multiple randomly generated instances of that identifier (e.g. English sentence, Math expression, etc) for you to read and enjoy!

#### Why does it matter?
Machine grammars are *incredibly* useful to industry and computer science in general. They can understand grammars -- both compiling and constructing content in their formats -- which makes them an invaluable tool to modern programmers; indeed, their first usage was to describe 
and compile the syntax of programming languages!

---

### How does it work?
It forms grammatical structures based on recursive term definitions. The concept is a bit tricky to wrap one's around, so let's go through an example, that of a mathematical grammar:

##### What is a number?
Well, it's a value that represents a quantity or amount of something.

##### But, grammatically?
Grammatically, a number (integer, at least) is literally just a string of digits. That's it; no more, no less, just multiple digits in a row.

##### Okay, what's a digit?
In words, a digit is either 0, 1, 2, 3, 4, 5, 6, 7, 8, or 9.

In Backus-Naur Form, we write that `<digit> ::= 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 ` which is the syntactically correct version of the same meaning.

In our version, we write `$digit ::= 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9` which is essentially the same as before (just with `$key` instead of `<key>`)

##### So, how do you specifically define a number, grammatically?
Since the size of a number is open-ended, the definition must be recursive. However, there's also a minimum number of digits possible: 1. What does that mean?

A number is either a single digit, or it is another number followed by a digit. `1` is both a digit and a number. `45` is a number (`4`) followed by a digit (`5`). `284` is a number (`28` (`2` followed by `8`)) followed by a digit (`4`). See? Every number can be recursively defined in this manner.

In Backus-Naur Form, we write `<number> ::= <digit> | <number><digit>` -- it's that simple!

This can be expanded indefinitely, to create any desirable grammar! In our code, we define a basic math grammar with 7 different terms:
```
$digit ::= 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9
$number ::= $digit | $number$digit
$variable ::= x | y | z | a | b | c | d
$expression ::= $variable | $number | $function | $expression $operator $expression
$function ::= $f($expression)
$f ::= sin | cos | tan
$operator ::= * | + | - | /
```

In reality, however, there's no limit! I'm going to expand this project to let everyone create their own grammars; check in about the progress (#38) if you're curious!

---

#### Why did you make this?
This early and necessary foray into the field of [Natural Language Processing (NLP)](https://en.wikipedia.org/wiki/Natural_language_processing) was part of my group's presentation on that field for [UW CSE 190E "Startup" in August 2018](https://courses.cs.washington.edu/courses/cse190e/18au/). It was wholly unnecessary for us to make something this complicated for a PowerPoint-based class lecture, but I figured it would prove an insightful and relatively simple demonstration of the power of natural language processing and machine grammars.

Really, I've been wanting to make something like this ever since I read the description of [Assignment 5 for UW CSE 143 in August 2017](https://courses.cs.washington.edu/courses/cse143/17au/handouts/10.html), and this was a pretty nice excuse.