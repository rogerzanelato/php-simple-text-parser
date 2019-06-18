# PHP Simple TextParser

## About

This is a simple, extensible, lightweight library with zero dependencies, made with the aim to make process of converting text files into structured data a little more easy.

Perfect to work with EDI Formats like Febraban CNAB240, Febraban CNAB400, Serasa Pefin etc..

**Atenttion: This library isn't ready for production yet and can have breaking changes in the next versions**

## How to use

To use this library you **must** create a Layout file defining how you want to parse a string.

You can also specify a class to use as "Encoder" and "Decoder", for example, you can definy an Encoder that gets a DateTime and encode it to to "2019-01-06" when Writing, and decode to a DateTime again when Reading.

**See folder `docs/samples/` to know the available configs**.

After the Layouts are created, you can also create a Template to combine multiple layouts and parse a String that has multiples pattern. **See sample 4 - Templates**.

## Todo

- Improve docs
- Create unit tests
- Create more loaders
- Create option to extend a Layout
- Implement an optional cache system for the template config
- Implement an Template Reader with Generator/Iterator
- Review the Unique Identification for Template Itens (array_count_values doesn't permit arrays)
- Create a default option for encode/decode
