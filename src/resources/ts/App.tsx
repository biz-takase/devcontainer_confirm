import { Counter } from "./components/Counter";

interface props {
    str: string;
    num: number;
    optional?: string;
}
// inline style
const stylecss = {
    fontSize: '100px',
}

const App = (props: props) => {
    const { str, num, optional } = props;

    return (
        <>
            <Counter />
            <div>
                <p style={stylecss}>props:{str}</p>
                <p>props:{num}</p>
                <p>optional:{optional}</p>
            </div>
        </>
    );
};

export default App;
