# WPGraphQl Redirection Plugin

Add WPGraphQl support for redirects made using the popular [Redirection Plugin](https://en-gb.wordpress.org/plugins/redirection/)

## Example Query

```graphql
redirection {
  redirects {
    groupId
    groupName
    origin
    target
    type
  }
}
```
