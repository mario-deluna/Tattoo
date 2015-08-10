Tattoo Language
===============

Tattoo is a simple hyper text programming / template language that renders into HTML.

[![Build Status](https://travis-ci.org/mario-deluna/Tattoo.svg)](https://travis-ci.org/mario-deluna/Tattoo)
[![Packagist](https://img.shields.io/packagist/dt/mario-deluna/tattoo.svg)]()
[![Packagist](https://img.shields.io/packagist/l/mario-deluna/tattoo.svg)]()
[![GitHub release](https://img.shields.io/github/release/mario-deluna/tattoo.svg)]()

```tattoo
h1 => 'Welcome to Tattoo :)'
```

_There are still PHP5.3 users and I don't want to discriminate these outlaws. Means Tattoo works from 5.3 to 7._

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
	[li][a .navigation-item ~ home] => 'Home' 
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

## Syntax

Let's just drive directly into the syntax.

### Nodes

Tattoo _nodes_ are basically HTML tags. So let's write the alltime classic hello world:

```tattoo
h1 => "Hello World"
```

```html
<h1>Hello World</h1>
```

You can use the first argument to add classes and set the nodes id.

```tattoo
h1 #page-title .underlined => "Hello World"
```

```html
<h1 id="page-title" class="underlined">Hello World</h1>
```

All other arguments will be used as node attributes.

```tattoo
a.btn.btn-sm, href: '/login' => 'Sign in'
```

```html
<a class="btn btn-sm" href="/login">Sign In</a>
```

#### Value less nodes 

Sometimes you want to create a node without any contents. 


```tattoo
[img src: 'logo.png']
```

```html
<img src="logo.png" />
```

#### Scoped nodes

Obviously you are going to build a tree structure with tattoo. Node definitions inside `[]` allow a scope.

```tattoo
[div.image-container]
{
	[img src: 'wallpaper.jpg']
}
```

```html
<div class="image-container">
	<img src="wallpaper.jpg">
</div>
```

You are still able to directly assign a text value.

```tattoo
[p] => 'Hello '
{
	span => 'World'
}
```

```html
<p>
	Hello <span>World</span>
</p>
```

#### Node tree

Often you have a tree with many levels that just contain one child. Instead of creating a scope for every level you can just forward them.


```tattoo
[header][nav.navbar][ul][li.active][a href: '/'] => 'Home'
{
	i.glyphicon ~ home => ''
}
```

```html
<header>
	<nav class="navbar">
		<ul>
			<li class="active">
				<a href="/">Home <i class="glyphicon glyphicon-home"></i></a>
			</li>
		</ul>
	</nav>
</header>
```

#### Appending classes

```tattoo
[div.row][div .col ~ md-4 ~ sm-6 ~ xs-12]
{
	a .btn ~ lg ~ primary ~ block => 'Click Me'
}
```

```html
<div class="row">
	<div class="col col-md-4 col-sm-6 col-xs-12">
		<a class="btn btn-lg btn-primary btn-block">Click Me</a>
	</div> 
</div>
```

---

## OLD STUFF KEEP UNTIL I REWROTE EVERYTHING

```tattoo
[form #login-form, action: '/login', method: 'post']
{
	p .info => "Please provide your login information."

	[input ]
}
```


```tattoo
button.btn title: 'Amazing Tooltip', data: {toggle: 'tooltip', placement: 'left'} => 'Hello!'
```

```html
<button class="btn" title="Amazing Tooltip" data-toggle="tooltip" data-placement="left" >Hello!</button>
```

### tag with scope



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

## Notes

_Notes to myself and everyone who's bored._

A node ( `[div]`, `span => 'foo'` ) always directly represents an element. All given data of such a node object is interpreted as element attribute.
Extending (`extend`) a node allows to a callback like thingy after a the given node has been created also from the context of the node.
Preparing (`prepare`) does the same thing as extend but the callback acts before any custom data is passed.
A view does not stand in any context of a node so all given data / arguments have to be handeled by the view itself.

You should be able to store nodes in variables and modify them before printing. ( see `concept/objectvars.tto`, `concept/bootstrapmodal.tto` )

Only nodes can be printed. When you print a string or a number to parser basically creates a text node.

A view can be loaded using the dobule point `:` initiator.