import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useFormAnalyticsStore = defineStore('formAnalytics', () => {
  const analyses = ref(new Map());
  const isAnalyzing = ref(false);
  const currentProgress = ref(0);

  const analyzeResponses = async (formId, responses) => {
    isAnalyzing.value = true;
    currentProgress.value = 0;
    
    try {
      const results = new Map();
      const total = responses.length;

      for (const [studentId, studentResponses] of Object.entries(responses)) {
        const analysis = await analyzeBullyingResponses(
          studentResponses.answers,
          studentResponses.studentName
        );
        
        results.set(studentId, {
          studentName: studentResponses.studentName,
          analysis,
          timestamp: new Date().toISOString(),
          riskLevel: extractRiskLevel(analysis)
        });

        currentProgress.value = (results.size / total) * 100;
      }

      analyses.value.set(formId, results);
      return results;
    } catch (error) {
      console.error('Error analitzant la resposta:', error);
      throw error;
    } finally {
      isAnalyzing.value = false;
      currentProgress.value = 0;
    }
  };

  const getAnalysis = (formId, studentId) => {
    return analyses.value.get(formId)?.get(studentId);
  };

  const getFormAnalyses = (formId) => {
    return analyses.value.get(formId);
  };

  const extractRiskLevel = (analysis) => {
    const riskMatch = analysis.match(/Risk Level: (Low|Medium|High)/i);
    return riskMatch ? riskMatch[1].toLowerCase() : 'unknown';
  };

  return {
    analyses,
    isAnalyzing,
    currentProgress,
    analyzeResponses,
    getAnalysis,
    getFormAnalyses
  };
});