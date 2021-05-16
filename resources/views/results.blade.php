<x-app-layout>
  <x-slot name="css">
    <link rel="stylesheet" href=".">
  </x-slot>
    
  <x-slot name="scripts">
    
  </x-slot>

  <x-searcher/>

<div id='tags'>
  <x-tags-of-results :quantity='10' :content="'book'"/> 

  <x-tags-of-results :quantity='2' :content="'podcast'"/> 

  <x-tags-of-results :quantity='150' :content="'revistas'"/> 
</div>

<div id='imgs'> 
  <x-content :rutaImagen="'http://t1.gstatic.com/images?q=tbn:ANd9GcRe-iwuP9o7Fs1FBdqX7s4f8DVKaxfg0ODrOHqMjLTMZ0PkcQ20'"/>
  <x-content :rutaImagen="'http://t1.gstatic.com/images?q=tbn:ANd9GcRe-iwuP9o7Fs1FBdqX7s4f8DVKaxfg0ODrOHqMjLTMZ0PkcQ20'"/>
  <x-content :rutaImagen="'http://t1.gstatic.com/images?q=tbn:ANd9GcRe-iwuP9o7Fs1FBdqX7s4f8DVKaxfg0ODrOHqMjLTMZ0PkcQ20'"/>
  <x-content :rutaImagen="'http://t1.gstatic.com/images?q=tbn:ANd9GcRe-iwuP9o7Fs1FBdqX7s4f8DVKaxfg0ODrOHqMjLTMZ0PkcQ20'"/>
  <x-content :rutaImagen="'http://t1.gstatic.com/images?q=tbn:ANd9GcRe-iwuP9o7Fs1FBdqX7s4f8DVKaxfg0ODrOHqMjLTMZ0PkcQ20'"/>
  <x-content :rutaImagen="'http://t1.gstatic.com/images?q=tbn:ANd9GcRe-iwuP9o7Fs1FBdqX7s4f8DVKaxfg0ODrOHqMjLTMZ0PkcQ20'"/>
  <x-content :rutaImagen="'http://t1.gstatic.com/images?q=tbn:ANd9GcRe-iwuP9o7Fs1FBdqX7s4f8DVKaxfg0ODrOHqMjLTMZ0PkcQ20'"/>
</div>
</x-app-layout>