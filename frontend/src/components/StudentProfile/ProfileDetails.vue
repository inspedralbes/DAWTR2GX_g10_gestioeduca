<template>
    <div class="bg-white pt-24"> 
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <ul role="list" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-12 xl:gap-16">
          <li v-for="person in people" :key="person.name" class="flex flex-col items-center text-center">
            <img class="w-40 h-40 rounded-full mx-auto" :src="person.imageUrl" alt="" />
            <h3 class="mt-6 text-3xl font-semibold tracking-tight text-gray-900">{{ person.name }}</h3>
            <p class="mt-4 text-lg font-semibold text-indigo-600">{{ person.role }}</p>
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script setup>
  const people = [
    {
      name: 'Leslie Alexander',
      role: '1r Batx',
      imageUrl:
        'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
  ]
  </script>
  
  <style scoped>
  /* Asegura que las imágenes se vean centradas y con un diseño atractivo */
  ul {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  }
  
  li {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
  
  img {
    width: 150px; 
    height: 150px;
    border-radius: 50%; 
    object-fit: cover; 
  }
  
  h3 {
    font-size: 1.5rem; 
  }
  
  p {
    font-size: 1rem;
  }
  </style>
  