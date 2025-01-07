export interface EvaluationProps {
    evaluation: Evaluation;
    responses: Message[];
}
export interface Evaluation {
    business_name: any;
    id: string;
    title: string;
    description: string;
    created_at: string;
}

export interface Message {
    id: string;
    evaluation_id: string;
    sender: MessegeSenderType;
    message: string;
}

export type MessegeSenderType = "assistant" | "user";
