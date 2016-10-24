<?php

/**
 * Description of RegexPattern
 * Constants containing the Regex patterns used by DataParser
 * @author Dan
 */
class RegexPattern {
    const _DATE = "/\d{1,2}\/\d{1,2}\/\d{2,4}/";
    const _PHONE = "/(?<=[^a-zA-Z0-9])(?:(?:\d{3}|\(\d{3}\))(?: |-)?)?\d{3}(?: |-)?\d{4}/";
    const _SALES ="/(?<=\\$)\d*\.[\d]{2}/";
    const _ACCOUNT = "/[a-zA-Z]{2}\d{4,8}/";
    const _MASTERKEY = "/(?:((?<=[^a-zA-Z0-9])(?:(?:\d{3}|\(\d{3}\))(?: |-)?)?\d{3}(?: |-)?\d{4})|([a-zA-Z]{2}\d{4,8})|((?<=\\$)\d*\.[\d]{2}))/";
}
