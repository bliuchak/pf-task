pf-task
=======

server part
---
* storing posts (title, text, timestamp, all plaintext)
* own administrative interface (simple form, without authorization and authentication)
* API for communicating with the client component
 
client part
---
* a separate part (ordinary HTML page + JavaScript)
* by communicating with the API server will dynamically list articles (title, text and date)
* when new post is added, it will appear in the client part (in 20 seconds)
