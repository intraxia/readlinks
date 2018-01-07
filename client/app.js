import './styles/main.less';
import 'babel-polyfill';
import { domDelta, observeDelta } from 'brookjs';
import { applyMiddleware, combineReducers, createStore } from 'redux';
import { composeWithDevTools } from 'redux-devtools-extension/developmentOnly';
import { init } from './actions';
import {} from './deltas';
import { el, view } from './dom';
import {} from './reducers';
import { selectProps } from './selectors';

const { __READLINKS_STATE__ } = global;

const compose = composeWithDevTools({
    name: 'readlinks'
});

const enhancer = compose(applyMiddleware(observeDelta(
    // Register your deltas here
    domDelta({ el, view, selectProps })
)));

const reducer = combineReducers({
    // Register your reducers here
});

const store = createStore(reducer, __READLINKS_STATE__, enhancer);

store.dispatch(init());
