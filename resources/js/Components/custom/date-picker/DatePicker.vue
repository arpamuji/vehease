<script setup lang="ts">
    import { Button } from '@/Components/ui/button';
    import { Calendar } from '@/Components/ui/calendar';
    import { Popover, PopoverContent, PopoverTrigger } from '@/Components/ui/popover';
    import { cn } from '@/lib/utils';
    import type { DateValue } from '@internationalized/date';
    import { DateFormatter, getLocalTimeZone, parseDate, today } from '@internationalized/date';
    import { CalendarIcon } from 'lucide-vue-next';
    import { computed } from 'vue';

    interface DatePickerProps {
        class?: string;
        modelValue?: string | null;
    }

    const props = withDefaults(defineProps<DatePickerProps>(), {
        class: '',
        modelValue: null,
    });

    const emit = defineEmits<{
        'update:modelValue': [value: string | null];
    }>();

    const defaultPlaceholder = today(getLocalTimeZone());

    const date = computed<DateValue | undefined>({
        get: () => {
            if (!props.modelValue) return undefined;
            try {
                return parseDate(props.modelValue);
            } catch {
                return undefined;
            }
        },
        set: (value) => {
            if (!value) {
                emit('update:modelValue', null);
                return;
            }
            const isoString = `${value.year}-${String(value.month).padStart(2, '0')}-${String(value.day).padStart(2, '0')}`;
            emit('update:modelValue', isoString);
        },
    });

    const df = new DateFormatter('en-US', {
        dateStyle: 'long',
    });
</script>

<template>
    <Popover v-slot="{ close }">
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                :class="cn('w-60 justify-start text-left font-normal', !date && 'text-muted-foreground', props.class)"
            >
                <CalendarIcon />
                {{ date ? df.format(date.toDate(getLocalTimeZone())) : 'Pick a date' }}
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0" align="start">
            <Calendar
                :model-value="date"
                @update:model-value="
                    (value) => {
                        date = value;
                        close();
                    }
                "
                :default-placeholder="defaultPlaceholder"
                layout="month-and-year"
                initial-focus
            />
        </PopoverContent>
    </Popover>
</template>
