<template>
    <div class="relative group h-48 flex   flex-col rounded-xl bg-bluegray bg-clip-border text-gray-900 shadow-md">

            <div class="h-28">
                <div
                    class="absolute -top-20 lg:top-[-10%] left-[5%] z-20  group-hover:top-[-30%] group-hover:opacity-[0.9]   duration-300 w-[90%] h-48 bg-red-600 rounded-xl justify-items-center align-middle">
                    <slot name="img"><img src="https://epicpadprinting.com/public/img/indus/Stationery.png"
                        class="w-36 h-36  mt-6 m-auto" alt="Promotional" title="Promotional" loading="lazy"
                        width="200" height="200"></slot>
                </div>
            </div>
            <div class="mt-8 z-10 w-full">
                <p
                    class="mb-2 inline-block text-center w-full text-2xl font-sans font-bold leading-snug tracking-normal antialiased">
                    <slot name="opcion">nombre_opcion</slot>
                </p>
            </div>
    </div>
</template>
<script>
export default{
    components:{
        Option,
    }
}
</script>
