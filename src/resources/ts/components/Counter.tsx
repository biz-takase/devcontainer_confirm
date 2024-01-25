import { useCounter } from "../hooks/useCounter";

export const Counter = () => {
    const { count, incrementCount, decrementCount } = useCounter();
    return (
        <>
            <div>
                <p>{count}</p>
            </div>
            <div>
                <button onClick={incrementCount}>カウントアップ</button>
                <button onClick={decrementCount}>カウントダウン</button>
            </div>
        </>
    );
};
