    @extends('principal')
    @section('contenido')
        <template v-if="menu==0">
        <h1>Contenido del menú 0</h1>
        </template>

        <template v-if="menu==1">
            <persona></persona>
        </template>

        <template v-if="menu==2">
            <h1>Contenido del menú 2</h1>
        </template>

        <template v-if="menu==3">
            <instituto></instituto>
        </template>

        <template v-if="menu==4">
            <tipo></tipo>
        </template>

        <template v-if="menu==5">
            <h1>Contenido del menú 5</h1>
        </template>

        <template v-if="menu==6">
            <h1>Contenido del menú 6</h1>
        </template>

        <template v-if="menu==7">
            <user></user>
        </template>

        <template v-if="menu==8">
            <roles></roles>
        </template>

        <template v-if="menu==9">
            <h1>Contenido del menú 9</h1>
        </template>

        <template v-if="menu==10">
            <h1>Contenido del menú 10</h1>
        </template>

        <template v-if="menu==11">
            <h1>Contenido del menú 11</h1>
        </template>

        <template v-if="menu==12">
            <h1>Contenido del menú 12</h1>
        </template>
        
    @endsection