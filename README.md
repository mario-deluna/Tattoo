Tattoo Language
===============

Tattoo is a simple hyper text programming / template language that renders into HTML.

[![Build Status](https://travis-ci.org/mario-deluna/Tattoo.svg)](https://travis-ci.org/mario-deluna/Tattoo)

```tattoo
h1 => 'Welcome to Tattoo :)'
```

## Tell me more!

A programming language written in PHP that compiles into PHP? When all you have is a hammer everything starts to look like a nail hu? 

Well no, when I wrote the first concept for this language I thought about building a native interpreter. But then more and more ideas came together how Tattoo should work and how people should be able to make use of it. I realised that you won't ever write stand alone applications with tattoo. So the result is a mixture between a programming language and a templating engine written in PHP for PHP. If this thing works, I would be happy to port this someday to ruby and js.

## The great goal

After years of developing web applications I've got kind of sick that the only thing that always stayed a mess was the HTML markup. So there was this idea stuck in my head of a templating engine that actually was a programming language. 

Let me show you an example:

```html
<ul id="main-navigation" class="nav">
	<li <?php if ($currentUrl === '/') : ?>class="active"<?php endif; ?>>
		<a 
			class="navigation-item 
				   navigation-item-home 
				   <?php if ($currentUrl === '/') : ?>
				   navigation-item-active
				   <?php endif; ?>" 
			href="/"
		>
			Home
		</a>
	</li>
</ul> 
```

This something i've seen a lot. We have got two inline statements here and honestly I dont know how to format that piece of code decently. Well this is the same piece of code in tattoo:

```tattoo
[ul #main-navigation .nav] 
{
	[li][a .navigation-item .navigation-item-home] => 'Home' 
	{
		if @currentUrl == '/' {
			@this.class.add('navigation-item-active')
			@this.parent.class.add('active')
		}
	}
}
```

Tattoo considers html tags as scoped objects this allows you to write your markup in a real new dynamic way.

---

**The language isn't done yet. It's just a concept. But I will do my best to create first prototype in the next few months.**

## Notes

_Notes to myself and everyone who's bored._

A node ( `[div]`, `span => 'foo'` ) always directly represents an element. All given data of such a node object is interpreted as element attribute.
Extending (`extend`) a node allows to a callback like thingy after a the given node has been created also from the context of the node.
Preparing (`prepare`) does the same thing as extend but the callback acts before any custom data is passed.
A view does not stand in any context of a node so all given data / arguments have to be handeled by the view itself.

You should be able to store nodes in variables and modify them before printing. ( see `concept/objectvars.tto`, `concept/bootstrapmodal.tto` )

Only nodes can be printed. When you print a string or a number to parser basically creates a text node.

A view can be loaded using the dobule point `:` initiator.



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
[a .ajax-trigger, href: "/notes/save/"]
{
	@this.data: { 
		noteId: 123, 
		userId: 42, 
		revision: 1 
	};
	
	@this.text = "Save your Note"
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

### Loops and tree modifications

```
@pages = {
	{ title: 'Home', link: '/home/', isActive: false },
	{ title: 'About', link: '/about/', isActive: true },
	{ title: 'Terms', link: '/terms/', isActive: false }
}

[ul .navigation]
{
	each @page in @pages
	{
		[li][a .navigation-item, href: @page.link]
		{
			span.navigation-item-title => @page.title
		
			if @page.isActive
			{
				@this.parent.class.add('active')
			}
		}
	}
}
```

HTML:

```html
<ul class="navigation">
	<li>
		<a class="navigation-item" href="/home/">
			<span class="navigation-item-title">Home</span>
		</a>
	</li>
	<li class="active">
		<a class="navigation-item" href="/about/">
			<span class="navigation-item-title">About</span>
		</a>
	</li>
	<li>
		<a class="navigation-item" href="/terms/">
			<span class="navigation-item-title">Terms</span>
		</a>
	</li>
</ul>
```

### Extending tags

```
// the '*' tells tattoo to not automatically print the tag
extend input*: @input
{
	[div .form-group]
	{
		@input.id = 'input-' + @input.name
		
		label .form-label, for: @input.id  => @input.placeholder
		
		@input.class.add( 'form-control' )
		
		if !@this.type {
			@this.type = 'text'
		}
		
		render @input
	}
}

[form action: '/login', method: 'post']
{
	[input name: 'username', placeholder: 'your username']
	[input name: 'password', placeholder: 'your password', type: 'password']
}
```

HTML: 

```html
<form action="/login" method="post">
	<div class="form-group">
		<label for="input-username">your username</label>
		<input id="input-username" class="form-control" type="text" name="username" placeholder="your username" />
	</div>
	<div class="form-group">
		<label for="input-password">your password</label>
		<input id="input-password"class="form-control" type="password" name="password" placeholder="your password" />
	</div>
</form>
```

### Views 

```
view page-header
{
	default @title = 'Unknown'
	default @subtitle = ''
	default @underline = true
	
	[div .page-title]
	{
		[h1]
		{
			print @title + ' '
			
			if @subtitle
			{
				small .subtitle => @subtitle
			}
			
			if @underline
			{
				[hr .page-title-underline]{}
			}
		}
	}
}

[page-header title: 'Welcome', subtitle: 'to tattoo']
```

HTML: 

```html
<div class="page-title">
	<h1>Welcome <small>to tattoo</small></h1>
	<hr class="page-title-underline" />
</div>
```
