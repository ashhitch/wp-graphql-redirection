=== Add GraphQL Redirection ===
Contributors: ash_hitch
Tags: Redirection, WPGraphQL, GraphQL, Headless WordPress, Decoupled WordPress
Requires at least: 5.0
Tested up to: 6.9
Requires PHP: 7.1
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html


Add WPGraphQl support for redirects made using the popular [Redirection Plugin](https://en-gb.wordpress.org/plugins/redirection/)
== Description ==

Add WPGraphQl support for redirects made using the popular [Redirection Plugin](https://en-gb.wordpress.org/plugins/redirection/)

== Example Query ==

`
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
`
