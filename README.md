# MailExceptionBundle

Email you when Symfony2 Exceptions occurs with some information.

Name | Badge | Name | Badge
--- | --- | --- | --- |
Build | [![Build Status](https://travis-ci.org/desarrolla2/MailExceptionBundle.svg)](https://travis-ci.org/desarrolla2/MailExceptionBundle) | Latest Stable | [![Latest Stable Version](https://poser.pugx.org/desarrolla2/mail-exception-bundle/v/stable.svg)](https://packagist.org/packages/desarrolla2/mail-exception-bundle)
Quality Score | [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/desarrolla2/MailExceptionBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/desarrolla2/MailExceptionBundle/) | Latest Unstable | [![Latest Unstable Version](https://poser.pugx.org/desarrolla2/mail-exception-bundle/v/unstable.svg)](https://packagist.org/packages/desarrolla2/mail-exception-bundle)
Code Coverage | [![Code Coverage](https://scrutinizer-ci.com/g/desarrolla2/MailExceptionBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/desarrolla2/MailExceptionBundle/) | Total Downloads | [![Total Downloads](https://poser.pugx.org/desarrolla2/mail-exception-bundle/downloads.svg)](https://packagist.org/packages/desarrolla2/mail-exception-bundle)
Insight | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/8a4bd559-c4dc-41f0-a405-90115a69062f/mini.png)](https://insight.sensiolabs.com/projects/8a4bd559-c4dc-41f0-a405-90115a69062f) |  License | [![License](https://poser.pugx.org/desarrolla2/mail-exception-bundle/license.svg)](https://packagist.org/packages/desarrolla2/mail-exception-bundle)
Dependencies | [![Dependency Status](https://www.versioneye.com/user/projects/546c88049dcf6d700900036f/badge.png)](https://www.versioneye.com/user/projects/546c88049dcf6d700900036f) | | |

## Installation

Download the Bundle.

```bash 
composer require "desarrolla2/mail-exception-bundle"
```

Enable the Bundle

```php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new  Desarrolla2\Bundle\MailExceptionBundle\MailExceptionBundle(),
        );

        // ...
    }

    // ...
}
```

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

When a exception occurs you will receive in your mail inbox something like this.

![screenshot](https://raw.githubusercontent.com/desarrolla2/MailExceptionBundle/master/Resources/doc/screenshot.png)

## Contact

You can contact with me on [@desarrolla2](https://twitter.com/desarrolla2).