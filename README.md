# WPGraphQl Redirection Plugin

![WPGraphQl Redirection Plugin](./banner.png)

Add WPGraphQl support for redirects made using the popular [Redirection Plugin](https://en-gb.wordpress.org/plugins/redirection/)

## Quick Install

-   Install & activate [WPGraphQL](https://www.wpgraphql.com/)
-   Install from the [WordPress Plugin Directory](https://wordpress.org/plugins/add-wpgraphql-redirection/)
-   or Clone or download the zip of this repository into your WordPress plugin directory & activate the plugin

## Composer

```
composer require ashhitch/wp-graphql-redirection
```

## Example Query

```graphql
redirection {
  redirects {
    groupId
    groupName
    origin
    target
    type
    matchType
  }
}
```
