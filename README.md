# MailExceptionBundle

Email you when Symfony2 Exceptions occurs with some information.

## Usage

You need put something like this in your config.yml

```yml
exception_listener:
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

## Contact

You can contact with me on [@desarrolla2](https://twitter.com/desarrolla2).