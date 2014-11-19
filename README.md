# MailExceptionBundle

Email you when Symfony2 Exceptions occurs with some information.

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

![screenshot]()

## Contact

You can contact with me on [@desarrolla2](https://twitter.com/desarrolla2).