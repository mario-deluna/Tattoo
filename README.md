Tattoo Template
===

Tattoo is a simple hyper text programming language that compiles into HTML.

---

**The language isn't done yet. It's just a concept yet.***

## Syntax

### simple tag

```
h1 #main-title => "Say hello to Tattoo"
```

HTML:

```html
<h1 id="main-title">Say hello to Tattoo</h1>
```

### tag with scope

```
[form #login-form, action="/login/"]
{
	span .info => "Please provide your login information."
}
```

HTML:

```html
<form id="login-form" action="/login/">
	<span class="info">Please provide you login information.</span>
</form>
```

### modifying scope data

```
[a .ajax-trigger, href="/notes/save/"]
{
	this.data: { noteId: 123, userId: 42, revision: 1 }
	
	print "Save your Note"
}
```

HTML:

```html
<a class="ajax-trigger" href="/notes/save/" data-noteId="123" data-userId="42" data-revision="1">Save your Note</a>
```

### The are vars

```
@applicationName = "Tattoo Application"

[head] {
	title => 'Welcome | ' + @applicationName
}
[body][footer] {
	span .small => 'Powerd by ' + @applicationName
}
```

HTML:

```html
<head>
	<title>Welcome | Tattoo Application</title>
</head>
<body>
	<footer>
		<span class="small">Powerd by Tattoo Application</span>
	</footer>
</body>
```