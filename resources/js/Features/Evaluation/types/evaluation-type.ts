export interface EvaluationProps {
    evaluation: Evaluation;
    responses: Message[];
}
export interface Evaluation {
    id: string;
    business_name: string;
    created_at: string;
    title: string;
    description: string;
}

export interface Message {
    id: string;
    evaluation_id: string;
    sender: MessegeSenderType;
    message: string;
}

export type MessegeSenderType = "assistant" | "user";
