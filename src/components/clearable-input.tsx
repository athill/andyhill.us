import {
  InputGroup,
  InputGroupAddon,
  InputGroupButton,
  InputGroupInput,
} from "@/components/ui/input-group"
import { X } from "lucide-react"

interface ClearableInputProps {
  value: string;
  setValue: (value: string) => void;
}

export const ClearableInput = ({ value, setValue, ...props }: ClearableInputProps) => {
  return (
    <div>
      <InputGroup>
        <InputGroupInput type="text" value={value} onChange={(e) => setValue(e.target.value)} {...props} />
        <InputGroupAddon align="inline-end">
          <InputGroupButton variant="outline" onClick={() => setValue('')}>
            <X />
          </InputGroupButton>
        </InputGroupAddon>
      </InputGroup>
    </div>
  );
};
