# MailExceptionBundle

Email you when Symfony2 Exceptions occurs with some information.

Name | Badge | Name | Badge
--- | --- | --- | --- |
Build | [[![Build Status](https://travis-ci.org/desarrolla2/MailExceptionBundle.svg)](https://travis-ci.org/desarrolla2/MailExceptionBundle) | Latest Stable | [![Latest Stable Version](https://poser.pugx.org/desarrolla2/mail-exception-bundle/v/stable.svg)](https://packagist.org/packages/desarrolla2/mail-exception-bundle)
Quality Score | [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/FastFeed/FastFeed/badges/quality-score.png?s=5ce39d3775f40b5946300404fa5fe3337a5ca66c)](https://scrutinizer-ci.com/g/FastFeed/FastFeed/) | Latest Unstable | [![Latest Unstable Version](https://poser.pugx.org/desarrolla2/mail-exception-bundle/v/unstable.svg)](https://packagist.org/packages/desarrolla2/mail-exception-bundle)
Code Coverage | [![Code Coverage](https://scrutinizer-ci.com/g/FastFeed/FastFeed/badges/coverage.png?s=50dbf6dfca4581c8e2761e5504d9de2a8db1d6fa)](https://scrutinizer-ci.com/g/FastFeed/FastFeed/) | Total Downloads | [![Total Downloads](https://poser.pugx.org/desarrolla2/mail-exception-bundle/downloads.svg)](https://packagist.org/packages/desarrolla2/mail-exception-bundle)
Insight | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/8a4bd559-c4dc-41f0-a405-90115a69062f/mini.png)](https://insight.sensiolabs.com/projects/8a4bd559-c4dc-41f0-a405-90115a69062f) |  License | [![License](https://poser.pugx.org/desarrolla2/mail-exception-bundle/license.svg)](https://packagist.org/packages/desarrolla2/mail-exception-bundle)
Dependencies | [![Dependency Status](https://www.versioneye.com/user/projects/546c88049dcf6d700900036f/badge.png)](https://www.versioneye.com/user/projects/546c88049dcf6d700900036f) | | |

## Installation

The complete instruction for bundles installation can be found on  
[symfony cookbook](http://symfony.com/doc/current/cookbook/bundles/installation.html)

The package name is "desarrolla2/mail-exception-bundle".

## Usage

You need put something like this in your config.yml

```yml
mail_exception:
    from: 'your@email.com'
    to: 'your@email.com'
    subject: 'An error has ocurred'
    avoid:
        environments: #this environments will be ignored
        
            - 'dev'
            - 'test'
            
        exceptions: #this exceptions will be ignored
        
            - 'Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException'
            - 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException'
            
```

## Example

When a exception occurs you will receive in out inbox something like this.

![screenshot](https://raw.githubusercontent.com/desarrolla2/MailExceptionBundle/master/Resources/doc/screenshot.png)

## Contact

You can contact with me on [@desarrolla2](https://twitter.com/desarrolla2).