<template>
    <div>
        {{currentPage}} / {{pageCount}}
        <pdf
            src="/public/reports/report1.pdf"
            @num-pages="pageCount = $event"
            @page-loaded="currentPage = $event"
        ></pdf>
    </div>
</template>

<script>

import pdf from 'vue-pdf'

export default {
    components: {
        pdf
    },
    data() {
        return {
            currentPage: 0,
            pageCount: 0,
        }
    }
}

</script>