<template>
    <tr>
        <th scope="row">{{ props.item.id + 1 }}</th>
        <td>
            <div>
                <input aria-label="item-name" placeholder="Item name" name="item_names[]" type="text" v-model="props.item.name" />
                <input aria-label="item-descriptions" v-model="props.item.description" name="item_descriptions[]"
                    type="text" placeholder="Item Description (optional)" />
            </div>
        </td>
        <td>
            <span class="me-2">Tk</span>
            <input aria-label="item-rate" class="d-inline-block text-end " name="item_rates[]" type="number" placeholder="00"
            v-model="props.item.rate" style="width: 6rem;" />
            <span class="me-2">.00</span>
            
            <div class="tax-wrapper">
                <a @click="toggleTaxPicker(props.item.id)" class="text-blue p-1 d-inline-block" tabindex="0" role="button">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0">
                            <span class="mdi mdi-plus fs-5"></span>Taxes
                        </p>
                    </div>
                </a>
                <div ref="taxPicker" class="tax-container" :class="{ 'd-none': !props.item.isTaxActive }">
                    <div @click="toggleTaxPicker(props.item.id)" class="close-icon d-inline-block" style="cursor: pointer;">
                        <CloseIcon class="" width="24" height="24"></CloseIcon>
                    </div>
                    <h5 class="title">Add Taxes</h5>
                    <div class="px-2">
                        <div v-for="tax in props.item.taxes" :key="tax.id as number"
                            class="d-flex align-items-center gap-1 mb-2">
                            <div class="w-50">
                                <label class="form-label mb-0">Rate</label>
                                <div class="d-flex">
                                    <input type="number" step="0.001" :name="`tax_rates[${props.item.id}][]`"
                                        class="w-100 border border-1 text-center rounded-0 rounded-start" placeholder="0"
                                        v-model="tax.rate" aria-label="Rate" aria-describedby="tax-addon1">
                                    <span
                                        class="bg-light rounded-0 rounded-end p-1 d-flex justify-content-center align-items-center text-dark fw-bold fs-5"
                                        id="tax-addon1">%</span>
                                </div>
                            </div>
                            <div class="">
                                <label class="form-label mb-0">Name</label>
                                <input type="text" :name="`tax_names[${props.item.id}][]`"
                                    class="w-100 border border-1 text-center p-1" placeholder="Tax Name" v-model="tax.name"
                                    aria-label="Tax Name">
                            </div>
                            <div class="w-50">
                                <label class="form-label mb-0">Number</label>
                                <input type="text" :name="`tax_numbers[${props.item.id}][]`"
                                    class="w-100 border border-1 text-center p-1" placeholder="Number" v-model="tax.number"
                                    aria-label="Tax Number">
                            </div>
                            <div class="align-self-end">
                                <span @click="deleteTaxItem(props.item.id, tax.id as number)"
                                    class="mdi mdi-trash-can-outline text-danger" style="cursor: pointer;"></span>
                            </div>
                        </div>
                        <button @click="addNewTaxItem(props.item.id)" type='button'
                            class='btn btn-soft-light text-dark py-1 w-100 border border-2 rounded'>Add New Tax</button>
                        <div class='d-flex justify-content-center align-items-center gap-2 my-3'>
                            <button @click="toggleTaxPicker(props.item.id)" type="button" class="btn btn-soft-info py-1"
                                style="cursor: pointer;">Close</button>
                            <button @click="() => {
                                calcTaxes(props.item.id)
                                toggleTaxPicker(props.item.id)
                            }" type='button' class='btn btn-success py-1' style="cursor: pointer;">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
        <td>
            <input aria-label="item-qty" name="item_qtys[]" type="number" v-model="props.item.qty" class="d-inline-block"
                style="width: 3rem;" />
        </td>
        <td>
            <div class="d-flex align-items-start">
                <span class="me-2">Tk</span>
                <input aria-label="item-total" id="item-total-0" data-index="0" name="item_totals[]" type="text"
                    v-model="props.item.total" placeholder="00" class="d-inline-block text-end" style="width: 7rem;" />
                <span class="me-2">.00</span>
                <span @click="deleteInvoiceItem(props.item.id, isEditMode)" data-index="0"
                    class="mdi mdi-trash-can-outline text-danger item-delete-btn" style="cursor:pointer;"></span>
            </div>
        </td>
    </tr>
</template>

<script setup lang="ts">
// @ts-ignore
import CloseIcon from './icons/CloseIcon.vue';
import { useInvoice } from '../composables/useInvoice';
import InvoiceItems, { InvoiceItem } from '../data';
import { onMounted, watch } from 'vue';

interface Props {
    item: InvoiceItem,
    isEditMode?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    isEditMode: false
}
)


const {
    deleteInvoiceItem,
    addNewTaxItem,
    deleteTaxItem,
    calcTaxes,
    toggleTaxPicker } = useInvoice()


watch([() => props.item.rate, () => props.item.qty], () => {
    if (props.item.rate !== undefined) {
        props.item.total = props.item.rate * props.item.qty
    } else {
        props.item.total = 0 * props.item.qty;
    }
    // calcTaxes(props.item.id)    
})
watch([() => props.item.total], () => {
    if (props.item.total !== undefined && props.item.qty === 1) {
        props.item.rate =  props.item.total
    }
    calcTaxes(props.item.id)    
})


</script>

<style scoped></style>