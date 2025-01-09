import { Ref, computed } from 'vue';

export function useEvaluationFilters(evaluations: Ref<any[]>, search: Ref<string>, selectedDate: Ref<string>, sortOrder: Ref<string>) {
  return computed(() => {
    let filtered = evaluations.value;
    
    if (search.value) {
      filtered = filtered.filter((evaluation) =>
        evaluation.business_name.toLowerCase().includes(search.value.toLowerCase())
      );
    }
    
    if (selectedDate.value) {
      filtered = filtered.filter((evaluation) =>
        evaluation.created_at.startsWith(selectedDate.value)
      );
    }
    
    return sortOrder.value === 'oldest' ? [...filtered].reverse() : filtered;
  });
}