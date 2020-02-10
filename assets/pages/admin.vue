<template>
    <md-table v-model="subscribers" md-sort="name" md-sort-order="asc" md-card>
        <md-table-toolbar>
            <div class="md-toolbar-section-start">
                <h2 class="md-title">Subscribers</h2>
            </div>

            <md-field md-clearable class="md-toolbar-section-end">
                <md-input placeholder="Enter here a string to search data..." v-model="search" @input="doSearch" />
            </md-field>
        </md-table-toolbar>

        <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell md-label="Name" md-sort-by="name">{{ item.name }}</md-table-cell>
            <md-table-cell md-label="Email" md-sort-by="email">{{ item.email }}</md-table-cell>
            <md-table-cell md-label="Categories" md-sort-by="categories">{{ item.categories }}</md-table-cell>
            <md-table-cell md-label="Job Title" md-sort-by="title">{{ item.title }}</md-table-cell>
        </md-table-row>

        <md-table-empty-state
                md-label="No subscribers found"
                :md-description="`No user found for this '${search}' query.`">
        </md-table-empty-state>
    </md-table>
</template>

<script>
    export default {
       data: () => {
         return {
             search: null,
             subscribers: []
         };
       },
        methods: {
            doSearch(items, termsearch) {
                return items;
            }
        }
    };
</script>